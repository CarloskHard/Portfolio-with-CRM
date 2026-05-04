# Mobile browser chrome, viewport units, and fullscreen backgrounds

A short playbook for when **fixed full-screen backgrounds** (canvas, WebGL, gradients) show **white strips**, **lag until touch end**, or **flicker constantly** on mobile — especially **Chrome / WebKit** when the **top URL bar and bottom navigation** show and hide during scroll.

Share this with teammates or other agents; adapt file paths and stack as needed.

---

## Symptoms you might see

1. **Hole / white band** at the top or bottom **while the finger is dragging**; it **repaints correctly when the finger is released**.
2. After a “fix” that reads **`visualViewport` on every scroll**, the layout is correct but the page **blinks or flickers** on every small scroll because the background is **resized or moved every frame**.

---

## Root cause (conceptual)

Mobile browsers use more than one notion of “viewport”:

- **Layout viewport**: used for laying out `position: fixed` and for many `window.innerHeight` updates. It can **update late** (e.g. after the gesture ends) when browser UI shows or hides.
- **Visual viewport**: what is **actually visible**. It can change **during** the gesture.

CSS height units behave differently:

| Unit   | Meaning (simplified)                                      |
|--------|------------------------------------------------------------|
| `vh`   | Often tied to a **stable** (or legacy) viewport height.   |
| `dvh`  | **Dynamic** — follows visible height as chrome animates. |
| `svh`  | **Small** — conservative (UI shown).                      |
| `lvh`  | **Large** — corresponds to when **UI is hidden** (max).  |

If a **fixed** layer is sized with something that **tracks the dynamic viewport** (`dvh` or live `visualViewport` + constant JS updates), the browser may **recomposite often** → **flicker**.

If a **fixed** layer is sized with something that **lags** behind the visible area (classic `100vh` only, or `window.innerHeight` before it updates), you can get a **temporary gap** (often read as white) until layout catches up.

**WebGL / canvas**: changing `canvas.width` / `canvas.height` clears the buffer and is expensive → makes flicker worse if triggered on scroll.

---

## Stable strategy (recommended default)

Goal: **one stable height for fullscreen decorative layers**, not recomputed on every scroll tick.

### 1. Prefer `lvh` for fixed “full bleed” backgrounds

Use the **large** viewport height so the background is **always at least as tall** as the “chrome hidden” case:

```css
.fullscreen-fixed-layer {
  position: fixed;
  inset: 0;
  width: 100vw; /* beware horizontal overflow on some layouts; clamp if needed */
  height: 100vh;
  height: 100lvh;
}
```

For **minimum page height** (avoid short pages + gap under footer):

```css
.page-min {
  min-height: 100vh;
  min-height: 100lvh;
}
```

**Trade-off**: when the browser UI **is visible**, there may be a **small excess** painted below the fold. That is usually **invisible during scroll** and **far preferable** to flicker or white flashes.

### 2. Resize WebGL/canvas only on real viewport changes — never on `scroll`

- Listen to **`resize`** (and optionally **`visualViewport.resize`** only if you truly need it).
- **Do not** tie buffer resize to `window` `scroll` or `visualViewport` `scroll` for a full-screen background.

```js
function scheduleResize(draw) {
  let id = 0;
  const run = () => {
    id = 0;
    draw();
  };
  return () => {
    if (id) return;
    id = requestAnimationFrame(run);
  };
}

const rerender = scheduleResize(updateCanvasSizeMaybe);
window.addEventListener('resize', rerender, { passive: true });

if (window.visualViewport) {
  window.visualViewport.addEventListener('resize', rerender, { passive: true });
}

// ❌ Avoid for backgrounds:
// window.addEventListener('scroll', rerender, { passive: true });
```

If you measure the canvas, prefer **`getBoundingClientRect()`** on the styled element **after** layout, instead of juggling `visualViewport.offsetTop` on every gesture.

### 3. Keep the canvas buffer change rate low

Only change `canvas.width` / `canvas.height` when dimensions **actually change** (rounded CSS pixels × `devicePixelRatio`). Never resize every animation frame unless unavoidable.

---

## Matching the root backdrop color

Transparent `body` + WebGL exposes whatever is behind: set **`html` background** (and optionally `body`) to **the same fallback color** as the shader clear color / design background so transient compositor gaps are not bright white.

---

## Viewport `<meta>` tag

- `viewport-fit=cover` is useful for notches / safe areas.
- **`interactive-widget=resizes-content`** (Chrome) can change how the layout viewport responds to the URL bar. Treat it as **optional** and **test both ways**; it can help or interact badly with your chosen `vh` strategy.

Do not rely on a single meta tag to fix all browsers; **CSS `*vh` + disciplined resize** is the portable core.

---

## What *not* to do (common anti-patterns)

1. **Infinite `requestAnimationFrame` loops** that read layout (`getBoundingClientRect`) every frame for UI that only needs updates on scroll position — starves the compositor and worsens mobile glitches.
2. **Pinning** `position: fixed` backgrounds to **`visualViewport` offsets** on **scroll** — fixes the gap but often **causes flicker** because every scroll event moves or resizes layers.
3. **`z-index: -1`** on fixed canvases without a clear stacking plan — can interact badly with root backgrounds; prefer `z-index: 0` on the canvas and **`position: relative; z-index: 1`** (or higher) on the main content stack.

---

## Quick decision table

| Priority                         | Use |
|----------------------------------|-----|
| No flicker, accept small overdraw| `100lvh` + resize only on `resize` / `visualViewport.resize` |
| Must track visible area exactly  | `100dvh` or `visualViewport` — expect more recompositions; **debounce** heavily |
| Legacy browsers without `lvh`    | `100vh` fallback first line, then `100lvh` second line |

---

## References (external)

- [MDN: CSS viewport units (`svh`, `lvh`, `dvh`)](https://developer.mozilla.org/en-US/docs/Web/CSS/length#relative_length_units_based_on_viewport)
- [MDN: Visual Viewport API](https://developer.mozilla.org/en-US/docs/Web/API/Visual_Viewport_API)
- [Chrome: Viewport resize behavior (`interactive-widget`)](https://developer.chrome.com/blog/viewport-resize-behavior/)

---

## Revision

- **2026-05-04**: Initial write-up from debugging a Laravel + Blade + WebGL + fixed background stack (Chrome / mobile UI show-hide, white gap vs flicker trade-offs).
