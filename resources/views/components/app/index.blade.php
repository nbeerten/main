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
    <script nonce="{{ csp_nonce() }}">
        partytown = {
            forward: [ "goatcounter" ],
            lib: "/vendor/partytown/",
        };
    </script>
    <script nonce="{{ csp_nonce() }}">
    {{!! File::get(public_path().'/vendor/partytown/partytown.js') !!}}
    </script>
    @vite('resources/scripts/app.ts')

    {{-- Stack of scripts from anywhere --}}
    @stack('scripts')

    {{-- Always load last to prevent errors of undefined functions --}}
    @vite('resources/scripts/alpine.ts')
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
    <!-- Goatcounter -->
    <script data-goatcounter="https://nilsbeerten.goatcounter.com/count" src="{{ Vite::asset("resources/scripts/count.js") }}" type="text/partytown"></script>
</body>
</html>
