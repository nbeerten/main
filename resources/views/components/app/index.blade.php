<!DOCTYPE html>
<html lang="{{ App::currentLocale() }}" dir="ltr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="preload" href="{{ Vite::asset('resources/fonts/Mona-Sans.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ Vite::asset('resources/fonts/Hubot-Sans.woff2') }}" as="font" type="font/woff2" crossorigin>
    {{-- Main JS & CSS from the compiled files --}}
    @vite('resources/css/app.css')
    <style nonce="{{ csp_nonce() }}">
        :root { 
            overflow-y: overlay;
        }

        [x-cloak] { 
            display: none !important; 
        }
    </style>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="manifest" href="/manifest.webmanifest">

    <meta name="theme-color" content="#171717">

    <x-app.seo />
    
    @stack('style')

    {{-- Main Javascript --}}
    @vite('resources/scripts/app.ts')

    {{-- Stack of scripts from anywhere --}}
    @stack('scripts')

    {{-- Always load last to prevent errors of undefined functions --}}
    @vite('resources/scripts/alpine.ts')

    <!-- Umami Analytics -->
    @guest
        <script async defer 
            data-website-id="ad9a9ebf-feb9-4204-88ef-1c11b9834ee5" 
            src="https://analytics.nilsbeerten.nl/umami.js"
            data-domains="nilsbeerten.nl">
        </script>
    @endguest
</head>

<body>
    <div class="main-wrapper">
        <x-nav />

        @isset($hero)
            @if($hero)
            {!! $hero !!}
            @endif
        @else
            <x-hero />
        @endisset

        {{-- Main content --}}
        <main>
            {{ $slot }}
        </main>
    </div>

    {{-- Footer --}}
    <span class="footer-divider"></span>
    <x-footer />

    <!-- SVG Stack -->
    <svg hidden style="display:none;visibility:hidden;">
        @stack('bladeicons')
    </svg>

    <!-- Script Stack -->
    @stack('footerscripts')
</body>
</html>
