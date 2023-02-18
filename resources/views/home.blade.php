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
        <div class="home-navbar-spacer"></div>
        <header class="home__header">
            <div class="logo-glow">
                <div class="background-glow"></div>
                <svg class="logo" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <mask id="mask">
                            <rect fill="white" width="100%" height="100%"/>
                            <path d="m104 745v-410a527 527 0 0 1 24-6q22-5 49-9a536 536 0 0 1 56-6 670 670 0 0 1 39-1 301 301 0 0 1 35 2q18 2 33 6a148 148 0 0 1 16 6 137 137 0 0 1 31 18 115 115 0 0 1 21 21 150 150 0 0 1 22 41 186 186 0 0 1 6 20 318 318 0 0 1 7 42 410 410 0 0 1 2 36v239h-111v-224a415 415 0 0 0-1-29q-3-37-13-56-13-26-55-26-13 0-25 1a419 419 0 0 0-17 2 494 494 0 0 0-8 1v332h-111zm449-13v-593l111-19v212a215 215 0 0 1 25-10 169 169 0 0 1 20-5q22-4 43-4 41 0 73 16 32 16 53 45a194 194 0 0 1 23 42 246 246 0 0 1 9 28 313 313 0 0 1 9 48 403 403 0 0 1 2 42 326 326 0 0 1-4 51 257 257 0 0 1-10 40 205 205 0 0 1-21 45 176 176 0 0 1-18 24 176 176 0 0 1-63 44 203 203 0 0 1-1 0 201 201 0 0 1-49 13 263 263 0 0 1-38 3q-43 0-88-6-45-6-76-16zm111-307v230a179 179 0 0 0 21 3 202 202 0 0 0 5 0 517 517 0 0 0 10 1q5 0 9 0a251 251 0 0 0 5 0 103 103 0 0 0 31-4 81 81 0 0 0 38-25 83 83 0 0 0 14-25q11-28 11-75a293 293 0 0 0-2-34q-4-35-18-57a62 62 0 0 0-45-30 87 87 0 0 0-14-1q-18 0-36 5a163 163 0 0 0-14 5q-9 3-16 7z" />
                            <rect x="10%" y="85.5%" width="80%" height="4%" rx="2%" />
                        </mask>
                    </defs>
                    <g>
                        <rect width="100%" height="100%" rx="12.5%" mask="url(#mask)" fill="currentColor" />
                    </g>
                </svg>
            </div>
            <div class="main">
                <h1 class="main-heading">Hai, I'm<br>
                    <span class="typewriter-text-wrapper"><span id="typewriter-text" aria-hidden="true" aria-label="Nils, nbert, or nbeerten.">Nils.</span></span>
                </h1>
            </div>
        </header>
    </x-slot:hero>

    <section class="home__projects">
        <h3 class="heading">Projects</h3>
        <div class="cards">
            <x-card.repository>
                <x-slot:img><x-image class="card-img" src="RefreshLeaderboard.webp" alt="Logo of RefreshLeaderboard plugin" height="160" width="160" /></x-slot:img>
                <a href="https://openplanet.dev/plugin/refreshleaderboard">
                    <h4 class="card-title">Refresh Leaderboard</h4>
                </a>
                <p class="card-text">
                    A plugin for the Trackmania scripting platform <a href="https://openplanet.dev/" target="_blank">Openplanet</a>, which provides a button to refresh the
                    leaderboard widget in the in-game UI.
                </p>

                <x-slot:repoinfo>
                    <a href="https://github.com/nbeerten/tm-refresh-leaderboard" target="_blank"><x-tabler-brand-github class="heroicons" /> nbeerten/tm-refresh-leaderboard</a>
                    
                    <ul class="card-repo-lang">
                        <li class="card-repo-lang-item">
                            <x-tabler-heart class="heroicons" /> Openplanet
                        </li>
                        <li class="card-repo-lang-item">
                            <x-tabler-braces class="heroicons" /> Angelscript
                        </li>
                    </ul>
                </x-slot:repoinfo>
            </x-card.repository>
            {{-- <x-card.repository>
                <x-slot:img><x-image class="card-img" src="tmasigns_1x1example.webp" alt="Example of a one by one sized sign" width="160" height="160" /></x-slot:img>
                <a href="/tmasigns">
                    <h4 class="card-title">TMA Sign Generator</h4>
                </a>
                <p class="card-text">
                    A tool that enables Trackmania mappers to create signs with customizable text that fit in with the TMA signpack.
                </p>

                <x-slot:repoinfo>
                    <a href="https://github.com/nbeerten/main" target="_blank"><x-tabler-brand-github class="heroicons" /> nbeerten/main</a>

                    <ul class="card-repo-lang">
                        <li class="card-repo-lang-item">
                            <x-tabler-brand-php class="heroicons" stroke-width="1.75" /> PHP
                        </li>
                        <li class="card-repo-lang-item">
                            <x-heroicon-m-photo /> Imagick
                        </li>
                    </ul>
                </x-slot:repoinfo>
            </x-card.repository> --}}
            <x-card.repository>
                <x-slot:img><x-image class="card-img" src="nextdotnilsbeerten_thumb.webp" alt="Thumbnail for next.nilsbeerten.nl project" width="160" height="160" /></x-slot:img>
                <h4 class="card-title">next.nilsbeerten.nl</h4>
                <p class="card-text">
                    A <b>secondary</b> backend hosted on the edge using the
                    <a href="https://nextjs.org/" target="_blank">Next.js</a> framework.
                    Provides Opengraph images for the main site using
                    <a href="https://vercel.com/docs/concepts/functions/edge-functions/og-image-generation" target="_blank">@vercel/og</a>.
                </p>
                
                <x-slot:repoinfo>
                    <a href="https://github.com/nbeerten/nb-next-api" target="_blank"><x-tabler-brand-github class="heroicons" /> nbeerten/nb-next-api</a>

                    <ul class="card-repo-lang">
                        <li class="card-repo-lang-item">
                            <x-tabler-brand-nextjs class="heroicons" /> Next.js
                        </li>
                        <li class="card-repo-lang-item">
                            <x-tabler-brand-typescript class="heroicons" /> TypeScript
                        </li>
                    </ul>
                </x-slot:repoinfo>
            </x-card.repository>
            {{-- <x-card.repository>
                <x-slot:img><x-image class="card-img" src="{{ asset('assets/favicon.svg') }}" alt="Logo of nilsbeerten.nl" width="160" height="160" /></x-slot:img>
                <a href="/">
                    <h4 class="card-title">nbeerten/main</h4>
                </a>
                <p class="card-text">
                    Github repository for this website, nilsbeerten.nl. This website is built using Laravel, Alpine.js, CSS and TypeScript.
                </p>
                
                <x-slot:repoinfo>
                    <a href="https://github.com/nbeerten/main" target="_blank"><x-tabler-brand-github class="heroicons" /> nbeerten/main</a>

                    <ul class="card-repo-lang">
                        <li class="card-repo-lang-item">
                            <x-tabler-brand-laravel class="heroicons" stroke-width="1.5"/> Laravel
                        </li>
                        <li class="card-repo-lang-item">
                            <x-tabler-brand-typescript class="heroicons" /> TypeScript
                        </li>
                        <li class="card-repo-lang-item">
                            <x-tabler-brand-css3 class="heroicons" /> CSS
                        </li>
                    </ul>
                </x-slot:repoinfo>
            </x-card.repository> --}}
        </div>
    </section>
</x-app>
