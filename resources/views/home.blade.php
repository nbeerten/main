@push('scripts')
    @vite('resources/scripts/pages/home.ts')
@endpush

@push('style')
<style type="text/css" nonce="{{ csp_nonce() }}">
.typed-cursor {
    opacity: 1;
}
.typed-cursor.typed-cursor--blink {
    animation: typedjsBlink 0.7s infinite;
    -webkit-animation: typedjsBlink 0.7s infinite;
    animation: typedjsBlink 0.7s infinite;
}
@keyframes typedjsBlink {
    50% {
        opacity: 0;
    }
}
@-webkit-keyframes typedjsBlink {
    0% {
        opacity: 1;
    }
    50% {
        opacity: 0;
    }
    100% {
        opacity: 1;
    }
}
</style>
@endpush

<x-app>
    <x-slot:hero>
        <header class="home__header" x-data 
            x-intersect:leave.margin.-64px.0.0.0="$dispatch('darkennavbar', true)"
            x-intersect:enter.margin.-64px.0.0.0="$dispatch('darkennavbar', false)">
            <div class="background-component large-glow"></div>
            <div class="background-component small-glow"></div>
            <div class="background-component left-glow-1"></div>
            <div class="background-component left-small-glow-2"></div>
            <div class="main">
                <h1 class="main-heading">Hai, I'm
                    <span class="typewriter-text-wrapper"><span id="typewriter-text" aria-hidden="true" aria-label="Nils, nbert, or nbeerten.">Nils.</span></span>
                </h1>
                <hr />
                <p class="info-text" x-data="{ time: new Date().toLocaleString('en-GB', { day: 'numeric', month: '2-digit', hour: '2-digit', minute: '2-digit', hour12: false, timeZone: 'Europe/Amsterdam' }) }">
                    <span>
                        <x-heroicon-m-map-pin />The Netherlands
                    </span>
                    <span>
                        <tool-tip role="tooltip" tip-position="block-end">Local Time</tool-tip>
                        <x-heroicon-m-clock /><span x-text="time">{{ now('Europe/Amsterdam')->isoFormat('DD/MM, HH:mm') }}</span>
                    </span>
                    <span class="divider"></span>
                    <span class="coding-languages" aria-roledescription="Frameworks and tools used:" role="list">
                        <a href="https://laravel.com/" target="_blank" aria-label="Laravel" role="listitem">
                            <tool-tip role="tooltip" tip-position="block-start">Laravel</tool-tip>
                            <x-simpleicon-laravel class="heroicons" aria-label="Laravel icon" width="36" />
                        </a>
                        <a href="https://www.php.net/" target="_blank" aria-label="PHP" role="listitem">
                            <tool-tip role="tooltip" tip-position="block-start">PHP</tool-tip>
                            <x-simpleicon-php class="heroicons" aria-label="PHP icon" width="36" />
                        </a>
                        <a href="https://developer.mozilla.org/en-US/docs/Web/CSS" target="_blank" aria-label="CSS3" role="listitem">
                            <tool-tip role="tooltip" tip-position="block-start">CSS</tool-tip>
                            <x-simpleicon-css3 class="heroicons" aria-label="CSS icon" width="36" />
                        </a>
                        <a href="https://alpinejs.dev/" target="_blank" aria-label="AlpineJS" role="listitem">
                            <tool-tip role="tooltip" tip-position="block-start">AlpineJS</tool-tip>
                            <x-simpleicon-alpinedotjs class="heroicons" aria-label="AlpineJS icon" width="36" />
                        </a>
                    </span>
                </p>
            </div>
        </header>
    </x-slot:hero>

    <section class="home__projects">
        <h3 class="heading">Projects</h3>
        <div class="cards">
            <x-card>
                <x-slot:img src="{{ asset('assets/RefreshLeaderboard.webp') }}" alt="Logo of RefreshLeaderboard plugin" width="160" height="160"></x-slot:img>
                <h4 class="card-title">Refresh Leaderboard</h4>
                <p class="card-text">
                    A plugin for the Trackmania scripting platform <a href="https://openplanet.dev/" target="_blank">Openplanet</a>, which provides a button to refresh the
                    leaderboard widget in the in-game UI.
                </p>

                <x-slot:footer>
                    <div class="helper_row-wrap">
                        <a href="https://github.com/nbeerten/tm-refresh-leaderboard" class="button" target="_blank">
                            <x-simpleicon-github class="heroicons" />
                        </a>
                        <a href="https://openplanet.dev/plugin/refreshleaderboard" class="button" target="_blank">
                            <x-heroicon-m-arrow-top-right-on-square /> Openplanet page
                        </a>
                    </div>
                </x-slot:footer>
            </x-card>
            {{-- <x-card>
                <x-slot:img src="{{ asset('assets/tmasigns_1x1example.webp') }}" alt="Example of a one by one sized sign"></x-slot:img>
                <h4 class="card-title">TMA Sign Generator</h4>
                <p class="card-text">
                    A tool powered by Imagick that enables mappers to create signs with customizable text that fit in with rest of TMA signpack.
                </p>
                
                <x-slot:footer>
                    <a href="https://github.com/nbeerten/main" class="button" target="_blank" aria-label="Github: nbeerten/main">
                        <x-simpleicon-github class="heroicons" />
                    </a>
                    <a href="/tmasigns" class="button">Visit tool</a>
                </x-slot:footer>
            </x-card> --}}
            <x-card>
                <x-slot:img src="{{ asset('assets/nextdotnilsbeerten_thumb.webp') }}" alt="Thumbnail for next.nilsbeerten.nl project" width="160" height="160">
                </x-slot:img>
                <h4 class="card-title">next.nilsbeerten.nl</h4>
                <p class="card-text">
                    A <b>secondary</b> backend hosted on the edge using the
                    <a href="https://nextjs.org/" target="_blank">Next.js</a> framework.
                    Provides Opengraph images for the main site using
                    <a href="https://vercel.com/docs/concepts/functions/edge-functions/og-image-generation" target="_blank">@vercel/og</a>.
                </p>
                <x-slot:footer>
                    <div class="helper_row-wrap">
                        <a href="https://github.com/nbeerten/nb-next-api" class="button" target="_blank">
                            <x-simpleicon-github class="heroicons" /> Github Repository
                        </a>
                    </div>
                </x-slot:footer>
            </x-card>
            {{-- <x-card>
                <x-slot:img src="{{ asset('assets/favicon.svg') }}" alt="Example of a one by one sized sign"></x-slot:img>
                <h4 class="card-title">nbeerten/main</h4>
                <p class="card-text">
                    Github repository for this website, nilsbeerten.nl. This website is built using Laravel, Alpine.js, CSS and TypeScript.
                </p>
                
                <x-slot:footer>
                    <a href="https://github.com/nbeerten/main" class="button" target="_blank">
                        <x-simpleicon-github class="heroicons" /> Github Repository
                    </a>
                </x-slot:footer>
            </x-card> --}}
        </div>
    </section>
</x-app>
