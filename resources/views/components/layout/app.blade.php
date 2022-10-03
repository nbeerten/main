<!DOCTYPE html>
<html lang="{{ App::currentLocale() }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>{{ $title }}</title>
    
    {{-- Main JS & CSS from the compiled files --}}
    <link rel="stylesheet" href="{{ mix('css/scss.css') }}">
    <script src="{{ mix('js/app.js') }}" defer></script>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">

    <link rel="apple-touch-icon" sizes="180x180" href="/ico/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/ico/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/ico/favicon-16x16.png">
    <link rel="mask-icon" href="/ico/safari-pinned-tab.svg" color="#fff">
    <meta name="theme-color" content="#171717">

    @isset($livewire) @if ($livewire)
        @livewireStyles
    @endif @endif
</head>

<body class="no-scrollbar">
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
                {!! $hero !!}
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

    @isset($bodyscripts)
        {!! $bodyscripts !!}
    @endisset
    @isset($livewire) @if ($livewire)
        @livewireScripts
    @endif @endif
</body>
</html>