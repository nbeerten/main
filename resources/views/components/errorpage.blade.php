@php
    App\Classes\SEO\SEO::make(
        title: $code,
        noindex: true
    );
@endphp

<x-layout.app title="{{ $title }}">
    <section class="default-page">
        <div class="error__card">
            <p class="code">{{ $code }}</p>
            <div class="main">
                <div class="info"> 
                    <p class="description">{{ $message }}</p>
                    <span class="request-path inline-code">{{ Request::method() }} /{{ Request::path() }}</span>
                </div>
                <a href="/" class="button">Return to homepage</a>
            </div>
        </div>
    </section>
</x-layout.app>
