@push('scripts')
    {{-- @vite('resources/scripts/prism.js') --}}
@endpush

<x-app>
    <x-slot:hero>
        <x-hero style="height: 30vh" />
    </x-slot:hero>
    <section class="posts-show">
        <article>
            <hgroup>
                <h1 class="heading">
                    {{ $post->title }}
                </h1>
                <div class="information">
                    <p>Posted by {{ $author->name }}</p>
                    <p>
                        <x-heroicon-o-newspaper/>
                        <time aria-label="Published at" 
                              datetime="{{ $post->date->isoFormat("YYYY-MM-DD") }}" 
                              x-data="{ time: new Date({{ $post->date->getTimestampMs() }}).toLocaleString('en', { month: 'long', day: 'numeric', year: 'numeric' }) }">
                              <tool-tip role="tooltip" tip-position="block-start">Published at</tool-tip>
                              <span x-text="time"></span>
                        </time>
                        <span aria-label="Page views">
                            <tool-tip role="tooltip" tip-position="block-start">Page views</tool-tip>
                            <x-heroicon-s-eye/><span id="goatcounterstats">0</span>
                        </span>
                    </p>
                </div>
            </hgroup>
            <section class="two-col">
                <section class="content markdown">
                    <x-markdown class="x-markdown" >
                        {!! $post->get('content') !!}
                    </x-markdown>
                </section>
                <aside>
                    @auth
                    <section>
                        <a href="{{ $post->edit_url }}" target="_blank" class="post-badge no-standard"><x-heroicon-m-pencil /> Edit </a>
                        @if(!$post->published)
                            <span class="post-badge"><x-heroicon-m-eye-slash /> Unpublished (Draft)</span>
                        @endif
                    </section>
                    <hr>
                    @endauth
                    <section class="toc">
                        <h2 class="toc__heading">Table of contents</h2>
                        <x-toc class="x-toc">
                            {!! $post->get('content') !!}
                        </x-toc>
                    </section>
                    <hr>
                    <section class="tags">
                        <h2 class="tags__heading">Tags</h2>
                        @foreach($post->tags as $tag)
                            <a href="/tags/{{ $tag->slug }}" class="post-badge no-standard">{{ $tag->title }}</a>
                        @endforeach
                    </section>
                    <hr>
                    <button class="permalink" :class="clicked ? 'copied' : ''" role="button" x-data="{ clicked: false }"
                        x-on:click="navigator.clipboard.writeText('{{ $post->permalink }}'); clicked = !clicked;">
                        <x-heroicon-o-clipboard-document-list />{{ $post->permalink }}
                    </button>
                    <figure>
                        <img src="{{ $post->featured_image }}">
                    </figure>
                </aside>
            </section>
        </article>
    </section>
</x-app>
