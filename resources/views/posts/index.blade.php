@php
    $articles = Statamic::tag('collection:posts')->limit(50)->fetch();

    use Spatie\SchemaOrg\Schema;

    App\Classes\SEO\SEO::make(
        title: "Posts",
        noindex: false
    );
@endphp

<x-layout.app>
    <section class="default-page posts-index">
        <h3 class="heading">Posts</h3>
            @if(count($articles) === 0)
                <div class="no-posts">
                    <p><i>Couldn't find any posts, waiting for non-existant content to magically appear...</i></p>
                </div>
            @else
            <div class="cards">
                @foreach($articles as $article)
                    <x-card class="post">
                        <x-slot:img src="{{ $article->featured_image }}" width="160" height="160"></x-slot:img>
                        <x-slot:title>{{ $article->title }}</x-slot:title>
                        {{ $article->meta_description }}

                        <x-slot:action>
                            <div class="action">
                                <span class="timestamp">
                                    <x-heroicon-o-newspaper/>
                                    <time datetime="{{ $article->date->isoFormat("YYYY-MM-DD") }}" x-data="{ time: new Date({{ $article->date->getTimestampMs() }}).toLocaleString('en', { month: 'long', day: 'numeric', year: 'numeric' }) }"><span x-text="time"></span></time>
                                </span>
                                <a href="{{ $article->permalink }}" rel="canonical" class="readmore">
                                    Read more...
                                </a>
                            </div>
                        </x-slot:action>
                    </x-card>
                @endforeach
            </div>
            @endif
    </section>
</x-layout.app>

