@php
    App\Classes\Opengraph\Opengraph::make(
        title: $page->title,
        description: $page->meta_description,
        thumbnail: $page->featured_image,
        noindex: true
    );
@endphp

@push('scripts')
    <script defer src='{{ mix('/js/prism.js', 'dist') }}'></script>
@endpush

<x-layout.app>
    <section class="posts-show">
        <article>
            <hgroup>
                <h1 class="heading">{{ $page->title }}</h1>
                <div class="information">
                    <span>
                        <x-heroicon-o-newspaper/>
                        <time datetime="{{ $page->date->isoFormat("YYYY-MM-DD") }}" x-data="{ time: new Date({{ $page->date->getTimestampMs() }}).toLocaleString('en', { month: 'long', day: 'numeric', year: 'numeric' }) }"><span x-text="time"></span></time>
                    </span>
                    <p>Posted by {{ $page->author->name }}</p>
                </div>
            <p></p>
            </hgroup>
            <hr>
            <section class="two-col">
                <section class="content markdown">
                    {!! $page->content !!}
                </section>
                <aside>
                    <button class="permalink" :class="clicked ? 'copied' : ''" role="button" x-data="{ clicked: false }"
                        x-on:click="navigator.clipboard.writeText('{{ $page->permalink }}'); clicked = !clicked;">
                        <x-heroicon-o-clipboard-document-list />{{ $page->permalink }}
                    </button>
                    <figure>
                        <img src="{{ $page->featured_image }}">
                    </figure>
                </aside>
            </section>
        </article>
    </section>
</x-layout.app>
