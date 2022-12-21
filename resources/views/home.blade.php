@push('scripts')
    @vite('resources/js/pages/home.js')
@endpush

<x-layout.app>
    <x-slot:hero>
        <header class="home__header">
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
                        <a href="https://statamic.com/" target="_blank" aria-label="Statamic" role="listitem">
                            <tool-tip role="tooltip" tip-position="block-start">Statamic</tool-tip>
                            <x-simpleicon-statamic class="heroicons" aria-label="Statamic icon" width="36" />
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
                <x-slot:img src="{{ asset('assets/nextdotnilsbeerten_thumb.webp') }}" alt="Thumbnail for next.nilsbeerten.nl project" width="160" height="160"></x-slot:img>
                <x-slot:title>next.nilsbeerten.nl</x-slot:title>
                    A <b>secondary</b> backend hosted on the edge using the 
                    <a href="https://nextjs.org/" target="_blank">Next.js</a> framework. Includes 
                    <a href="https://vercel.com/docs/concepts/functions/edge-functions/og-image-generation" target="_blank">@vercel/og</a> to generate
                    Opengraph images for the main site.
                <x-slot:action>
                    <div class="helper_row-wrap">
                        <a href="https://github.com/nbeerten/nb-next-api" class="button" target="_blank">
                            <x-simpleicon-github class="heroicons" /> Github Repository
                        </a>
                    </div>
                </x-slot:action>
            </x-card>
            {{-- <x-card>
                <x-slot:img src="{{ asset('assets/tmasigns_1x1example.webp') }}" alt="Example of a one by one sized sign"></x-slot:img>
                <x-slot:title>TMA Sign Generator</x-slot:title>
                A small web application to create signs with text defined by the user for Trackmania, styled to fit in with the TMA signpack.
                
                <x-slot:action>
                    <a href="/tmasigns" class="button">Visit page</a>
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
