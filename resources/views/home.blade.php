@push('scripts')
    @vite('resources/js/pages/home.js')
@endpush

<x-layout.app>
    <x-slot:hero>
        <header class="home__header">
            <div class="main">
                <h2 class="main-heading">Hai, I'm <span id="typewriter-text">Nils.</span></h2>
                <p class="info-text" x-data="{ time: new Date().toLocaleString('en-GB', { day: 'numeric', month: '2-digit', hour: '2-digit', minute: '2-digit', hour12: false, timeZone: 'Europe/Amsterdam' }) }">
                    <span>
                        <x-heroicon-m-map-pin />The Netherlands
                    </span>
                    <span class="divider"></span>
                    <span>
                        <tool-tip role="tooltip" tip-position="block-end">Local Time</tool-tip>
                        <x-heroicon-m-clock /><span x-text="time"></span><noscript>{{ now('Europe/Amsterdam')->isoFormat('DD/MM, HH:mm') }}</noscript>
                    </span>
                </p>
                <div class="icon-groups">
                    <div class="socials">
                        <a href="https://twitter.com/nbertn" target="_blank" aria-label="twitter: @nbertn">
                            <tool-tip role="tooltip" tip-position="block-start">@nbertn</tool-tip>
                            <x-simpleicon-twitter />
                        </a>
                        <a href="https://youtube.com/channel/UC-bj0JxjTzxnL2LSQMEx6MA" target="_blank" aria-label="youtube: nbert">
                            <tool-tip role="tooltip" tip-position="block-start">nbert</tool-tip>
                            <x-simpleicon-youtube />
                        </a>
                        <a href="https://github.com/nbeerten" target="_blank" aria-label="github: nbeerten">
                            <tool-tip role="tooltip" tip-position="block-start">nbeerten</tool-tip>
                            <x-simpleicon-github />
                        </a>
                        <a href="https://discord.com/invite/TdRSgYjJ7S" target="_blank" aria-label="discord: nbert#2620">
                            <tool-tip role="tooltip" tip-position="block-start">nbert#2620</tool-tip>
                            <x-simpleicon-discord />
                        </a>
                    </div>
                    <span class="divider"></span>
                    <div class="coding-languages">
                        <a href="https://laravel.com/" target="_blank" aria-label="Laravel">
                            <tool-tip role="tooltip" tip-position="block-start">Laravel</tool-tip>
                            <x-simpleicon-laravel />
                        </a>
                        <a href="https://www.php.net/" target="_blank" aria-label="PHP">
                            <tool-tip role="tooltip" tip-position="block-start">PHP</tool-tip>
                            <x-simpleicon-php />
                        </a>
                        <a href="https://sass-lang.com/" target="_blank" aria-label="SCSS">
                            <tool-tip role="tooltip" tip-position="block-start">SCSS</tool-tip>
                            <x-simpleicon-sass />
                        </a>
                        <a href="https://alpinejs.dev/" target="_blank" aria-label="AlpineJS">
                            <tool-tip role="tooltip" tip-position="block-start">AlpineJS</tool-tip>
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
                A plugin for the Trackmania scripting platform <a href="https://openplanet.dev/" target="_blank">Openplanet</a>, which provides a button to refresh the leaderboard widget in the in-game UI.

                <x-slot:action>
                    <div class="helper_row-wrap">
                        <a href="https://github.com/nbeerten/tm-refresh-leaderboard" class="button" target="_blank">
                            <x-simpleicon-github class="heroicons" />
                        </a>
                        <a href="https://openplanet.dev/plugin/refreshleaderboard" class="button" target="_blank">
                            <x-heroicon-m-arrow-top-right-on-square /> Openplanet page
                        </a>
                    </div>
                </x-slot:action>
            </x-card>
            <x-card>
                <x-slot:img src="{{ asset('assets/logo_white.svg') }}" alt="Logo of nilsbeerten.nl" width="160" height="160" loading="lazy"></x-slot:img>
                <x-slot:title>Website Rewrite</x-slot:title>
                Website rewrite: Now using Laravel on the backend, together with SCSS for styling and AlpineJS & vanilla JS for frontend functionality.
                
                <x-slot:action>
                    <a href="" disabled onclick="event.preventDefault()" class="button" target="_blank">
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

    @if(count($posts) > 0 )
        <section class="posts">
            <h3 class="heading">Posts</h3>
            <div class="cards">
                @foreach($posts as $post)
                    <x-card class="post">
                        @foreach (Statamic::tag('glide:generate')->src($post->featured_image)->width(400)->format('webp') as $image)
                            <x-slot:img src="{{ $image['url'] }}" width="{{ $image['width'] }}" alt="Featured image of post" loading="lazy"></x-slot:img>
                        @endforeach
                        
                        <x-slot:title>{{ $post->title }}</x-slot:title>
                        {{ $post->meta_description }}

                        <x-slot:action>
                            <div class="action">
                                <span class="timestamp">
                                    <x-heroicon-o-newspaper/>
                                    <time datetime="{{ $post->date->isoFormat("YYYY-MM-DD") }}" x-data="{ time: new Date({{ $post->date->getTimestampMs() }}).toLocaleString('en', { month: 'long', day: 'numeric', year: 'numeric' }) }"><span x-text="time"></span></time>
                                </span>
                                <a href="{{ $post->permalink }}" class="readmore">
                                    Read more...
                                </a>
                            </div>
                        </x-slot:action>
                    </x-card>
                @endforeach
            </div>
        </section>
    @endif
</x-layout.app>
