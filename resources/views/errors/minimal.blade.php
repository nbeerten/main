<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        {{-- Main CSS from the compiled files --}}
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    </head>
    <body>
        <div class="flex items-center justify-center min-h-screen bg-gray-900 bg-cover bg-center" style="background-image: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.9)), var(--nb-heroimage);">
            <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col items-center pt-8">
                    <div class="px-4 text-8xl text-white">
                        @yield('code')
                    </div>

                    <div class="text-xl text-gray-300 uppercase">
                        @yield('message')
                    </div>
                    
                    <div class="text-lg text-gray-300 mt-4">
                        <a href="/" class="bg-stone-900 hover:bg-stone-800 px-3 py-1 rounded">Return to homepage</a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
