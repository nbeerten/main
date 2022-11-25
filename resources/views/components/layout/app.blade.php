<!DOCTYPE html>
<html lang="{{ App::currentLocale() }}" class="theme-dark">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    {{-- Main JS & CSS from the compiled files --}}
    <link rel="stylesheet" href="{{ mix('/css/app.css', 'dist') }}">
    <link rel="preload" href="{{ asset('/fonts/Mona-Sans.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ asset('/fonts/Hubot-Sans.woff2') }}" as="font" type="font/woff2" crossorigin>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="manifest" href="/manifest.webmanifest">

    <meta name="theme-color" content="#171717">

    <x-layout.seo />
    
    <!-- Style Stack -->
    @stack('style')
    <!-- Head Scripts Stack -->
    @stack('headscripts')
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
    <script src="{{ mix('/js/app.js', 'dist') }}" defer></script>
    @stack('scripts')
    @production
    <!-- Cloudflare Web Analytics -->
    <script defer src='https://static.cloudflareinsights.com/beacon.min.js' data-cf-beacon='{"token": "d7046c97f3134ce3ba2831d8ccdb239a"}'></script>
    <!-- End Cloudflare Web Analytics -->
    @endproduction
</body>
</html>
