@push('scripts')
    <script defer src='{{ mix('/js/home.js', 'dist') }}'></script>
@endpush

<x-layout.app title="Home">
    <x-slot:description>
        Hai, I'm Nils. Projects include Refresh Leaderboard: a plugin for Openplanet and the rewrite of nilsbeerten.nl...
    </x-slot:description>

    <x-slot:hero>
        <header class="home__header">
            <div>
                <h2 class="main-heading">Hai, I'm <span id="typewriter-text"></span><noscript>Nils.</noscript></h2>
                <p class="info-text" x-data="{ time: new Date().toLocaleString('en-GB', { day: 'numeric', month: '2-digit', hour: '2-digit', minute: '2-digit', hour12: false, timeZone: 'Europe/Amsterdam' }) }">
                    <span>
                        <x-heroicon-m-map-pin />The Netherlands
                    </span>
                    <span class="divider"></span>
                    <span data-popup-bottom="Local Time">
                        <x-heroicon-m-clock /><span x-text="time"></span><noscript>{{ now('Europe/Amsterdam')->isoFormat('DD/MM, HH:mm') }}</noscript>
                    </span>
                </p>
                <div class="icon-groups">
                    <div class="socials">
                        <a href="https://twitter.com/nbertn" target="_blank" data-popup="@nbertn" aria-label="twitter: @nbertn">
                            <x-simpleicon-twitter />
                        </a>
                        <a href="https://youtube.com/channel/UC-bj0JxjTzxnL2LSQMEx6MA" target="_blank" data-popup="nbert" aria-label="youtube: nbert">
                            <x-simpleicon-youtube />
                        </a>
                        <a href="https://github.com/nbeerten" target="_blank" data-popup="nbeerten" aria-label="github: nbeerten">
                            <x-simpleicon-github />
                        </a>
                        <a href="https://discord.com/invite/TdRSgYjJ7S" target="_blank" data-popup="nbert#2620" aria-label="discord: nbert#2620">
                            <x-simpleicon-discord />
                        </a>
                    </div>
                    <span class="divider"></span>
                    <div class="coding-languages">
                        <a href="https://laravel.com/" target="_blank" data-popup="Laravel" aria-label="Laravel">
                            <x-simpleicon-laravel />
                        </a>
                        <a href="https://www.php.net/" target="_blank" data-popup="PHP" aria-label="PHP">
                            <x-simpleicon-php />
                        </a>
                        <a href="https://sass-lang.com/" target="_blank" data-popup="SCSS" aria-label="SCSS">
                            <x-simpleicon-sass />
                        </a>
                        <a href="https://alpinejs.dev/" target="_blank" data-popup="AlpineJS" aria-label="AlpineJS">
                            <x-simpleicon-alpinedotjs />
                        </a>
                    </div>
                </div>
            </div>
        </header>
    </x-slot:hero>

    <section class="home__projects">
        <h3 class="heading">Projects</h3>
        <div class="cards">
            <x-card>
                <x-slot:img src="{{ asset('assets/RefreshLeaderboard.webp') }}" alt="Logo of RefreshLeaderboard plugin" width="160" height="160"></x-slot:img>
                <x-slot:title>Refresh Leaderboard</x-slot:title>
                A plugin for the Trackmania scripting platform Openplanet, which provides a button to refresh the leaderboard widget in the in-game UI.

                <x-slot:action>
                    <a href="https://github.com/nbeerten/tm-refresh-leaderboard" class="button">
                        <x-heroicon-m-arrow-top-right-on-square /> Visit github repository
                    </a>
                </x-slot:action>
            </x-card>
            <x-card>
                <x-slot:img src="{{ asset('assets/logo_white.svg') }}" alt="Logo of nilsbeerten.nl" width="160" height="160"></x-slot:img>
                <x-slot:title>Website Rewrite</x-slot:title>
                Website rewrite: Now using Laravel on the backend, together with SCSS for styling and AlpineJS & vanilla JS for frontend functionality.
                
                <x-slot:action>
                    <a href="" disabled onclick="event.preventDefault()" class="button">
                        <x-heroicon-m-arrow-top-right-on-square /> Visit github repository
                    </a>
                </x-slot:action>
            </x-card>
            {{-- <x-card>
                <x-slot:img src="{{ asset('assets/tmasigns_1x1example.webp') }}" alt="Example of a one by one sized sign"></x-slot:img>
                <x-slot:title>TMA Signs Generator</x-slot:title>
                Small web application to create signs for the game Trackmania with user input as text on the image, styled to fit in with the TMA signpack.
                
                <x-slot:action>
                    <a href="/tmasigns" class="button">Go to page</a>
                </x-slot:action>
            </x-card> --}}
        </div>
    </section>
</x-layout.app>
