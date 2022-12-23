@push('scripts')
    @vite('resources/scripts/prism.js')
@endpush

<x-layout.app>
    <section class="posts-show">
        <article>
            <hgroup>
                <h1 class="heading">{{ $post->title }}</h1>
                <div class="information">
                    <p>Posted by {{ $post->author->name }}</p>
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
            <hr>
            <section class="two-col">
                <section class="content markdown">
                    {!! $post->content !!}
                </section>
                <aside>
                    <button class="permalink" :class="clicked ? 'copied' : ''" role="button" x-data="{ clicked: false }"
                        x-on:click="navigator.clipboard.writeText('{{ $post->permalink }}'); clicked = !clicked;">
                        <x-heroicon-o-clipboard-document-list />{{ $post->permalink }}
                    </button>
                    <figure>
                        <img src="{{ $post->featured_image }}">
                    </figure>
                    <div class="views">
                    </div>
                </aside>
            </section>
        </article>
    </section>
</x-layout.app>
