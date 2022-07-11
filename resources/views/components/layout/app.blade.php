<!DOCTYPE html>
<html lang="{{ App::currentLocale() }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>{{ $title }} - Nils Beerten</title>
    
    {{-- Main JS & CSS from the compiled files --}}
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script src="{{ mix('js/app.js') }}"></script>

    {{-- AlpineJS --}}
    <script src="{{ mix('js/alpinejs.js') }}" defer></script>
</head>

<body class="text-white bg-neutral-900 no-scrollbar"> 
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
    <main class="max-w-7xl mx-auto px-4 sm:px-5 md:px-6 lg:px-8">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <span class="block border-t border-zinc-500 w-full h-px mt-4"></span>
    <x-layout.footer class="px-4 mx-auto max-w-7xl sm:px-5 md:px-6 lg:px-8" />

</body>
</html>