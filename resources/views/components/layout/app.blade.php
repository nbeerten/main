<!DOCTYPE html>
<html lang="{{ App::currentLocale() }}" class="theme-dark">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="preload" href="{{ Vite::asset('resources/fonts/Mona-Sans.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ Vite::asset('resources/fonts/Hubot-Sans.woff2') }}" as="font" type="font/woff2" crossorigin>
    {{-- Main JS & CSS from the compiled files --}}
    @vite('resources/css/app.css')

    <link rel="preload" href="{{ Vite::asset('public/assets/hero@768p.webp') }}" as="image" type="image/webp" media="(min-aspect-ratio: 16/9) and (max-width: 1366px), (max-aspect-ratio: 16/9) and (max-height: 768px)">
    <link rel="preload" href="{{ Vite::asset('public/assets/hero@1080p.webp') }}" as="image" type="image/webp" media="(min-aspect-ratio: 16/9) and (min-width: 1367px) and (max-width: 1920px), (max-aspect-ratio: 16/9) and (min-height: 769px) and (max-width: 1080px)">
    <link rel="preload" href="{{ Vite::asset('public/assets/hero@1440p.webp') }}" as="image" type="image/webp" media="(min-aspect-ratio: 16/9) and (min-width: 1921px) and (min-width: 2560px), (max-aspect-ratio: 16/9) and (min-width: 1081px) and (min-width: 1440px)">
    <link rel="preload" href="{{ Vite::asset('public/assets/hero.webp') }}" as="image" type="image/webp" media="(min-aspect-ratio: 16/9) and (min-width: 2561px), (max-aspect-ratio: 16/9) and (min-width: 1441px)">

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="manifest" href="/manifest.webmanifest">

    <meta name="theme-color" content="#171717">

    <x-layout.seo />
    
    @stack('style')
    @vite('resources/js/app.js')
    @stack('scripts')
</head>

<body>
    <div class="main-wrapper">
        <x-layout.nav />

        @isset($hero)
            @if($hero)
            {!! $hero !!}
            @endif
        @else
            <x-layout.hero />
        @endisset

        {{-- Main content --}}
        <main>
            {{ $slot }}
        </main>
    </div>

    {{-- Footer --}}
    <span class="footer-divider"></span>
    <x-layout.footer />

    <!-- SVG Stack -->
    <svg hidden style="display:none;visibility:hidden;">
        @stack('bladeicons')
    </svg>

    <!-- Script Stack -->
    @stack('footerscripts')
    <!-- Goatcounter -->
    <script data-goatcounter="https://nilsbeerten.goatcounter.com/count"
        async src="//gc.zgo.at/count.js"></script>
</body>
</html>
