<!DOCTYPE html>
<html lang="{{ App::currentLocale() }}" class="theme-dark">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    {{-- Main JS & CSS from the compiled files --}}
    {{-- <link rel="stylesheet" href="{{ mix('/css/app.css', 'dist') }}"> --}}
    @vite('resources/scss/app.scss')
    @vite('resources/js/app.js')

    <link rel="preload" href="{{ Vite::asset('resources/fonts/Mona-Sans.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ Vite::asset('resources/fonts/Hubot-Sans.woff2') }}" as="font" type="font/woff2" crossorigin>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="manifest" href="/manifest.webmanifest">

    <meta name="theme-color" content="#171717">

    <x-layout.seo />
    
    <!-- Style Stack -->
    @stack('style')
    <!-- Head Scripts Stack -->
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
    @stack('bodyscripts')
    <!-- Goatcounter -->
    <script data-goatcounter="https://nilsbeerten.goatcounter.com/count"
        async src="//gc.zgo.at/count.js"></script>
    <!-- Goatcounter -->
</body>
</html>
