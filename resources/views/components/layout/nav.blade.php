<nav class="fixed top-0 left-0 right-0 z-50 w-full border-b shadow-2xl bg-zinc-900/50 backdrop-blur border-zinc-500 shadow-black/80">
    <div class="px-4 mx-auto max-w-7xl lg:px-8">
        <div class="flex items-center h-16 ">
            <div class="flex items-center flex-shrink-0">
                <a href="/"><img fetchpriority="high" height="32" width="32" class="w-auto h-8 pointer-events-none select-none" src="{{ asset('assets/logo_white.svg') }}" alt="NB logo"></a>
            </div>
            <div class="flex ml-6 space-x-4">
                <a href="{{ route("home") }}" @class([
                    'navitem-active' => Request::routeIs('home'),
                    'navitem-inactive' => ! Request::routeIs('home')
                ])>Home</a>
            </div>
            <div class="grow"></div>
            <div class="flex items-center mx-4 flex-shrink-0 md:absolute md:top-0 md:right-4 md:h-full">
                <a href="https://github.com/nbeerten/main" target="_blank" class="flex flex-row items-center justify-center gap-x-2 w-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-5 w-5" viewBox="0 0 16 16">
                        <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z"/>
                    </svg>
                    <span class="hidden sm:block">GitHub</span>
                </a>
            </div> 
        </div>
    </div>
</nav>