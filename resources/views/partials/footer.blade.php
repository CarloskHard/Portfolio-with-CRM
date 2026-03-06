<footer id="main-footer" class="bg-[#0b0f1a] text-gray-400 py-10 border-t border-gray-800/50">
    <div class="max-w-7xl mx-auto px-8 md:px-12 flex flex-col md:flex-row justify-between items-center gap-8">
        
        <div class="order-2 md:order-1">
            <p class="text-sm font-light tracking-wide text-gray-500">
                &copy; {{ date('Y') }}
                <span class="js-footer-name-spotlight footer-name-wrapper mx-1 inline-block cursor-default relative text-indigo-400 font-medium">
                    <span class="footer-name-vfx-base">
                        @foreach(mb_str_split('Carlos Codes') as $i => $char)
                        <span class="footer-name-char" style="--char-index: {{ $i }}">{{ $char }}</span>
                        @endforeach
                    </span>
                    <span class="footer-name-vfx-sweep" aria-hidden="true">
                        @foreach(mb_str_split('Carlos Codes') as $i => $char)
                        <span class="footer-name-char" style="--char-index: {{ $i }}">{{ $char }}</span>
                        @endforeach
                    </span>
                </span>
                <span class="hidden md:inline-block mx-2 text-gray-700">|</span>
                <span class="js-footer-design-spotlight footer-design-wrapper inline-block cursor-default relative">
                    <span class="footer-design-base text-gray-500">Diseño & Desarrollo</span>
                    <span class="footer-design-reflection" aria-hidden="true">Diseño & Desarrollo</span>
                </span>
            </p>
        </div>

        <div class="flex flex-wrap items-center justify-center md:justify-end gap-6 order-1 md:order-2">
            <a href="{{ env('APP_LINKEDIN_URL') }}" target="_blank" class="group">
                <button type="button" class="footer-btn group-hover:border-[#0077b5] group-hover:text-white">
                    <x-icons.linkedin class="w-5 h-5 transition-colors duration-300" /> 
                    <span class="text-sm font-medium">LinkedIn</span>
                </button>
            </a>
            <a href="{{ env('APP_GITHUB_URL') }}" target="_blank" class="group">
                <button type="button" class="footer-btn group-hover:border-[#3CCF91] group-hover:text-white">
                    <x-icons.github class="w-5 h-5 transition-colors duration-300" />
                    <span class="text-sm font-medium">GitHub</span>
                </button>
            </a>
            <a href="mailto:{{ env('APP_CONTACT_EMAIL') }}" class="group">
                <button type="button" class="footer-btn border-l border-gray-800 pl-6 ml-2 group-hover:text-white">
                    <x-icons.email class="w-5 h-5 transition-colors duration-300" />
                    <span class="text-sm font-medium">Email</span>
                </button>
            </a>
        </div>
    </div>
</footer>