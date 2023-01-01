<x-layout.app>
    <section class="default-page posts-index">
        <h1 class="heading">Tag: {{ $tag->title }}</h1>
            @if(count($posts) === 0)
                <div class="no-posts">
                    <p><i>No post with the tag "{{ $tag->title }}" found.</i></p>
                </div>
            @else
            <div class="cards">
                @foreach($posts as $post)
                    <x-card class="post">
                        <x-slot:img src="{{ $post->featured_image }}" width="160" height="160"></x-slot:img>
                        <x-slot:title>{{ $post->title }}</x-slot:title>
                        {{ $post->summary }}

                        <x-slot:action>
                            <div class="action">
                                <span class="timestamp">
                                    <x-heroicon-o-newspaper/>
                                    <time datetime="{{ $post->date->isoFormat("YYYY-MM-DD") }}" x-data="{ time: new Date({{ $post->date->getTimestampMs() }}).toLocaleString('en', { month: 'long', day: 'numeric', year: 'numeric' }) }"><span x-text="time"></span></time>
                                </span>
                                <a href="{{ $post->permalink }}" rel="canonical" class="readmore">
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

