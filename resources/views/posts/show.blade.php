@php
    use Spatie\SchemaOrg\Schema;

    $schema = Schema::BlogPosting()
        ->headline($page->title)
        ->datePublished($page->date->isoFormat('YYYY-MM-DDThh:mm:ssZ'))
        ->author(Schema::person()->name($page->author->name))
        ->image([$page->featured_image ?? (env('APP_URL') . "/og?url=" . Request::path() . "&title=" . $seo->title ?? Request::path() )]);

    App\Classes\SEO\SEO::make(
        title: $page->title,
        description: $page->meta_description,
        thumbnail: $page->featured_image,
        noindex: false,
        type: [
            "type" => "article",
            "items" => [
                "author" => $page->author->name,
                "published_time" => $page->date->isoFormat('YYYY-MM-DDThh:mm:ssZ')
            ]
        ],
        schema: $schema->toScript()
    );

@endphp

@push('scripts')
    <script defer src='{{ mix('/js/prism.js', 'dist') }}'></script>
    <script>
        var r = new XMLHttpRequest();
        r.addEventListener('load', function() {
            document.querySelector('#stats').innerText = JSON.parse(this.responseText).count
        })
        r.open('GET', 'https://nilsbeerten.goatcounter.com/counter/' + location.pathname + '.json')
        r.send()
    </script>
@endpush

<x-layout.app>
    <section class="posts-show">
        <article>
            <hgroup>
                <h1 class="heading">{{ $page->title }}</h1>
                <div class="information">
                    <p>Posted by {{ $page->author->name }}</p>
                    <p>
                        <x-heroicon-o-newspaper/>
                        <time style="position: relative" data-popup="Published at" aria-label="Published at" datetime="{{ $page->date->isoFormat("YYYY-MM-DD") }}" x-data="{ time: new Date({{ $page->date->getTimestampMs() }}).toLocaleString('en', { month: 'long', day: 'numeric', year: 'numeric' }) }"><span x-text="time"></span></time>
                        <span style="position: relative" data-popup="Page views" aria-label="Page views"><x-heroicon-s-eye/> <span id="stats">1</span></span>
                    </p>
                </div>
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
                    <div class="views">
                    </div>
                </aside>
            </section>
        </article>
    </section>
</x-layout.app>
