@push('scripts')
    <script defer src='{{ mix('/js/home.js', 'dist') }}'></script>
@endpush

<x-layout.app title="Home">
    <x-slot:ogdescription>
        Hai, I'm Nils. Also known as nbeerten or nbert.
    </x-slot:ogdescription>
    
    <x-slot:hero>
        <header class="home__header">
            <div>
                <h2 class="main-heading">Hai, I'm <span id="typewriter-text"></span><noscript>Nils.</noscript></h2>
                <p class="info-text"
                   x-data="{ time: new Date().toLocaleString('en-GB', {day: 'numeric', month: '2-digit', hour: '2-digit', minute: '2-digit', hour12: false, timeZone: 'Europe/Amsterdam' }) }">
                <span><x-heroicon-m-map-pin/>The Netherlands</span>
                <span class="divider"></span>
                <span data-popup-bottom="Local Time"><x-heroicon-m-clock/><span x-text="time"></span></span></p>
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
            <div class="card">
                <img loading="lazy" src="{{ asset('assets/RefreshLeaderboard.webp') }}" alt="Logo of RefreshLeaderboard plugin">
                <div class="content">
                    <h4 class="heading">Refresh Leaderboard</h4>
                    <p class="long-text">A plugin for the Trackmania scripting platform Openplanet, which provides a button to refresh the leaderboard widget in the in-game UI. </p>
                    <div class="helper_grow"></div>
                    <a href="https://github.com/nbeerten/tm-refresh-leaderboard" class="button"><x-heroicon-m-arrow-top-right-on-square/> Visit github repository</a>
                </div>
            </div>
            <div class="card">
                <img loading="lazy" src="{{ asset('assets/logo_white.svg') }}" alt="Logo of nilsbeerten.nl">
                <div class="content">
                    <h4 class="heading">Website Rewrite</h4>
                    <p class="long-text">Website rewrite: Now using Laravel on the backend, together with SCSS for styling and AlpineJS & vanilla JS for frontend functionality.</p>
                    <div class="helper_grow"></div>
                    <a href="" class="button" disabled onclick="event.preventDefault()"><x-heroicon-m-arrow-top-right-on-square/> Visit github repository</a>
                </div>
            </div>
            {{-- <div class="card">
                <img loading="lazy" src="{{ asset('assets/tmasigns_1x1example.webp') }}" alt="Example of a one by one sized sign">
                <div class="content">
                    <h4 class="heading">TMA Signs Generator</h4>
                    <p class="long-text">Small web application to create signs for the game Trackmania with user input as text on the image, styled to fit in with the TMA signpack. </p>
                    <div class="helper_grow"></div>
                    <a href="/tmasigns" class="button">Go to page</a>
                </div>
            </div> --}}
        </div>
    </section>
</x-layout.app>