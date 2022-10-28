<!DOCTYPE html>
<html lang="{{ App::currentLocale() }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>{{ $title ?? Request::path() }} - Nils Beerten</title>
    @isset($opengraph)
        <meta name="description" content="{{ $opengraph ?? '' }}">
    @endisset

    {{-- Main JS & CSS from the compiled files --}}
    <link rel="stylesheet" href="{{ mix('/css/app.css', 'dist') }}">

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">

    <link rel="apple-touch-icon" sizes="180x180" href="/ico/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/ico/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/ico/favicon-16x16.png">
    <link rel="mask-icon" href="/ico/safari-pinned-tab.svg" color="#fff">
    <meta name="theme-color" content="#ffdf00">

    @isset($opengraph)
        <!-- Facebook Meta Tags -->
        <meta property="og:url" content="{{ Request::fullUrl() }}">
        <meta property="og:og:site_name" content="nilsbeerten.nl">
        <meta property="og:type" content="website">
        <meta property="og:title" content="{{ $title ?? Request::path() }} - Nils Beerten">
        <meta property="og:description" content="{{ $opengraph ?? '' }}">
        <meta property="og:image" content="{{ $opengraph->attributes->get('img') ?? '' }}">

        <!-- Twitter Meta Tags -->
        <meta name="twitter:card" content="summary_large_image">
        <meta property="twitter:domain" content="nilsbeerten.nl">
        <meta property="twitter:url" content="{{ Request::fullUrl() }}">
        <meta name="twitter:creator" content="@nbertn">
        <meta name="twitter:site" content="@nbertn">
        <meta name="twitter:title" content="{{ $title ?? Request::path() }} - Nils Beerten">
        <meta name="twitter:description" content="{{ $opengraph ?? '' }}">
        <meta name="twitter:image" content="{{ $opengraph->attributes->get('img') ?? '' }}">
    @endisset
    
    <!-- Style Stack -->
    @stack('style')
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