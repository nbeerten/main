<!DOCTYPE html>
<html lang="{{ App::currentLocale() }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>{{ $title ?? Request::path() }} - Nils Beerten</title>
    
    {{-- Main JS & CSS from the compiled files --}}
    <link rel="stylesheet" href="{{ mix('/css/app.css', 'dist') }}">
    <script src="{{ mix('/js/app.js', 'dist') }}" defer></script>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">

    <!-- Facebook Meta Tags -->
    <meta property="og:url" content="{{ Request::fullUrl() }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $title ?? Request::path() }} - Nils Beerten">
    <meta property="og:description" content="{{ $ogdescription ?? '' }}">
    <meta property="og:image" content="{{ $ogimage ?? '' }}">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary">
    <meta property="twitter:domain" content="nilsbeerten.nl">
    <meta property="twitter:url" content="{{ Request::fullUrl() }}">
    <meta name="twitter:creator" content="@nbertn">
    <meta name="twitter:title" content="{{ $title ?? Request::path() }} - Nils Beerten">
    <meta name="twitter:description" content="{{ $ogdescription ?? '' }}">
    <meta name="twitter:image" content="{{ $ogimage ?? '' }}">

    <link rel="apple-touch-icon" sizes="180x180" href="/ico/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/ico/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/ico/favicon-16x16.png">
    <link rel="mask-icon" href="/ico/safari-pinned-tab.svg" color="#fff">
    <meta name="theme-color" content="#171717">
    
    <!-- Style Stack -->
    @stack('style')
</head>

<body>
    <div class="main-wrapper">
        {{-- Navbar and hero sections --}}
        <header>
            {{-- Main navigation bar --}}
            <x-layout.nav />

            {{-- 
            Hero section: Map screenshot with a set height. Overwritable:
            <x-slot:hero>
                <div> (Your content here) </div>
            </x-slot:hero>
            --}}
            @isset($hero)
                @if($hero)
                {!! $hero !!}
                @endif
            @else
                <x-layout.hero />
            @endisset

        </header>

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
    @stack('scripts')
</body>
</html>