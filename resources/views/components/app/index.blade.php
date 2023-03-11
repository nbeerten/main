<!DOCTYPE html>
<html lang="{{ App::currentLocale() }}" dir="ltr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="preload" href="{{ Vite::asset('resources/fonts/Mona-Sans.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ Vite::asset('resources/fonts/Hubot-Sans.woff2') }}" as="font" type="font/woff2" crossorigin>
    
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

    {!! $seo->toHtml() !!}
    
    @stack('style')

    {{-- Main Javascript --}}
    @vite('resources/scripts/app.ts')

    {{-- Stack of scripts from anywhere --}}
    @stack('scripts')

    {{-- Always load last to prevent errors of undefined functions --}}
    @vite('resources/scripts/alpine.ts')
</head>

<body>
    @guest
        <script type="text/javascript" nonce="{{ csp_nonce() }}">
            var _paq = _paq || [];
            _paq.push(["trackPageView"]);
            _paq.push(["enableLinkTracking"]);
            _paq.push(["disableCookies"]);
            _paq.push(["setSessionIdStrictPrivacyMode", true]);
            (function() {
                var u = "https://nilsbeerten.piwik.pro/";
                _paq.push(["setTrackerUrl", u + "ppms.php"]);
                _paq.push(["setSiteId", "bd110934-c4ad-401a-8b2c-4628ff327201"]);
                var d = document,
                    g = d.createElement("script"),
                    s = d.getElementsByTagName("script")[0];
                g.type = "text/javascript";
                g.async = true;
                g.defer = true;
                g.src = u + "ppms.js";
                s.parentNode.insertBefore(g, s);
            })();
        </script>
    @endguest

    <x-nav />
    
    <div class="app">
        @isset($hero)
            {!! $hero !!}
        @else
            <x-hero />
        @endisset

        <main>
            {{ $slot }}
        </main>
    </div>

    {{-- Footer --}}
    <span class="footer-divider"></span>
    <x-footer />

    {{-- SVG Stack --}}
    <svg hidden style="display:none;visibility:hidden;">
        @stack('bladeicons')
    </svg>

    {{-- Script Stack --}}
    @stack('footerscripts')
</body>
</html>
