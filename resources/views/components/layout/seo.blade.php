<meta name="robots" content="{{ ($seo->noindex ?? false) ? 'noindex' : '' }} noimageindex">
<title>{{ $seo->title ?? Request::path() }} - Nils Beerten</title>

@isset($seo)
    @if($seo->description && $seo->title)
    <meta name="description" content="{{ $seo->description }}">

    <!-- Opengraph Meta Tags -->
    <meta property="og:url" content="{{ Request::fullUrl() }}">
    <meta property="og:site_name" content="nilsbeerten.nl">
    <meta property="og:title" content="{{ $seo->title ?? Request::path() }} - Nils Beerten">
    <meta property="og:description" content="{{ $seo->description }}">
    
    @isset($seo->thumbnail)
        <meta property="og:image" content="{{ $seo->thumbnail }}">
    @else
        <meta property="og:image" content="{{ env('APP_URL') }}/og?url={{ Request::path() }}&title={{ $seo->title ?? Request::path() }}">
        <meta property="og:image:width" content="1200" />
        <meta property="og:image:height" content="600" />
        <meta property="og:image:alt" content="Preview of the page together with the page title and website logo" />
    @endisset

    @if($seo->type)
    <meta property="og:type" content="{{ $seo->type['type'] }}">
    @foreach($seo->type['items'] as $key => $item)
        <meta property="{{ $seo->type['type'] }}:{{ $key }}" content="{{ $item }}">
    @endforeach
    @else
        <meta property="og:type" content="website">
    @endif

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta property="twitter:domain" content="nilsbeerten.nl">
    <meta property="twitter:url" content="{{ Request::fullUrl() }}">
    <meta name="twitter:creator" content="@nbertn">
    <meta name="twitter:site" content="@nbertn">
    <meta name="twitter:title" content="{{ $seo->title ?? Request::path() }} - Nils Beerten">
    <meta name="twitter:description" content="{{ $seo->description }}">

    @isset($seo->thumbnail)
        <meta property="twitter:image" content="{{ $seo->thumbnail }}">
    @else
        <meta property="twitter:image" content="{{ env('APP_URL') }}/og?url={{ Request::path() }}&title={{ $seo->title ?? Request::path() }}">
    @endisset

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
    @if($seo->schema)
        {!! $seo->schema !!}
    @endif
@endisset