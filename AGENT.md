# AGENT.md - Checklist general para proyectos Laravel (500 y permisos)

Antes de aplicar estas reglas del proyecto, leer también la guía común para todos los proyectos:

- `/var/www/AGENTS_COMMON.md`

Este archivo resume tips reutilizables para evitar errores comunes entre proyectos.

## 1) Diagnóstico rapido cuando aparece Error 500

1. Revisar el log primero:
   - `storage/logs/laravel.log`
2. Si el error menciona `Permission denied` en:
   - `storage/framework/views`
   - `storage/logs`
   - `bootstrap/cache`
   suele ser un problema de permisos/propietario.
3. Limpiar caches de Laravel:
   - `php artisan optimize:clear`
   - `php artisan view:clear`
4. Volver a probar.

## 2) Permisos recomendados (entorno local Linux/WSL + Docker/Sail)

Ejecutar desde la raiz del proyecto:

```bash
sudo chown -R $USER:www-data storage bootstrap/cache
sudo chmod -R ug+rwx storage bootstrap/cache
find storage -type f -exec chmod 664 {} \;
find storage -type d -exec chmod 775 {} \;
find bootstrap/cache -type f -exec chmod 664 {} \;
find bootstrap/cache -type d -exec chmod 775 {} \;
```

Notas:
- Evitar `chmod -R 777` salvo diagnostico puntual.
- Si usas contenedores, confirmar que el usuario del proceso web puede escribir en esas rutas.

### Mezcla de propietarios en `storage/framework/views`

Si comandos ejecutados como tu usuario CLI (p. ej. `php artisan` sin Sail) llegaron a compilar vistas, los ficheros pueden quedar como `usuario:usuario` mientras PHP-FPM/Apache suele ejecutarse como `www-data`. Entonces cualquier cambio en Blade fuerza una recompilacion y Laravel intenta hacer `file_put_contents` sobre el mismo hash: **falla con Permission denied** y la pagina responde 500.

Mitigaciones:
- Correccion estable: usar la secuencia de `chown`/`chmod` de arriba (requiere poder aplicar grupo `www-data` o el usuario del proceso web).
- Rapida si no tienes sudo: borrar compilados que no pertenecen al usuario del servidor web y vaciar caches de vista, por ejemplo:
  ```bash
  find storage/framework/views -maxdepth 1 -type f -name '*.php' ! -user www-data -delete
  php artisan view:clear
  ```
  Ajusta `www-data` al usuario efectivo si difiere en tu equipo o contenedor.

## 3) Secuencia minima para "proyecto recien clonado"

```bash
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate
php artisan storage:link
npm install
npm run dev
```

Si usas Sail, anteponer `./vendor/bin/sail` a los comandos de `php artisan`, `composer` y `npm`.

## 4) Causas comunes de 500 (ademas de permisos)

- Variables faltantes en `.env` (DB, APP_KEY, APP_URL).
- Dependencias no instaladas (`vendor/` o `node_modules/` incompletos).
- Cachés antiguas tras cambiar `.env` o config.
- Migraciones pendientes.
- Errores de sintaxis en Blade/PHP.

## 5) Checklist de prevencion rapida

- Confirmar `.env` correcto para el entorno.
- Ejecutar `php artisan optimize:clear` al cambiar configuraciones.
- Verificar permisos de `storage/` y `bootstrap/cache/`.
- Revisar `laravel.log` antes de tocar codigo.
- Documentar el fix aplicado en este archivo si vuelve a ocurrir.

## 6) Comandos de recuperacion rapida

```bash
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

En Sail:

```bash
./vendor/bin/sail artisan optimize:clear
```

---

Si aparece un 500, **primero log + permisos**, despues cache y entorno.
