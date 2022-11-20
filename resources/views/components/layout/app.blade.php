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

    <meta name="robots" content="{{ ($opengraph->noindex ?? false) ? 'noindex' : '' }} noimageindex">
    <title>{{ $opengraph->title ?? Request::path() }} - Nils Beerten</title>
    
    @isset($opengraph)
        @if($opengraph->description && $opengraph->title)
            <meta name="description" content="{{ $opengraph->description }}">

            <!-- Facebook Meta Tags -->
            <meta property="og:url" content="{{ Request::fullUrl() }}">
            <meta property="og:og:site_name" content="nilsbeerten.nl">
            <meta property="og:type" content="website">
            <meta property="og:title" content="{{ $opengraph->title ?? Request::path() }} - Nils Beerten">
            <meta property="og:description" content="{{ $opengraph->description }}">
            <meta property="og:image" 
                  @if($opengraph->thumbnail !== false)
                  content="{{ $opengraph->thumbnail }}">
                  @else
                    content="{{ env('APP_URL') }}/og?url={{ Request::path() }}&title={{ $opengraph->title ?? Request::path() }}">
                  @endif
            <meta property="og:image:width" content="1200" />
            <meta property="og:image:height" content="600" />
            <meta property="og:image:alt" content="Preview of the page together with the page title and website logo" />

            <!-- Twitter Meta Tags -->
            <meta name="twitter:card" content="summary_large_image">
            <meta property="twitter:domain" content="nilsbeerten.nl">
            <meta property="twitter:url" content="{{ Request::fullUrl() }}">
            <meta name="twitter:creator" content="@nbertn">
            <meta name="twitter:site" content="@nbertn">
            <meta name="twitter:title" content="{{ $opengraph->title ?? Request::path() }} - Nils Beerten">
            <meta name="twitter:description" content="{{ $opengraph->description }}">
            <meta name="twitter:image" content="{{ env('APP_URL') }}/og?url={{ Request::path() }}&title={{ $opengraph->title ?? Request::path() }}">

            @if(Request::is('/'))
            <script type="application/ld+json">
                {
                    "@context": "https://schema.org",
                    "@type": "Organization",
                    "url": "https://nilsbeerten.nl/",
                    "logo": "https://nilsbeerten.nl/icon-512.png"
                }
            </script>
            @endif
        @endif
    @endisset
    
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
