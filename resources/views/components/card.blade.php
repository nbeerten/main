<article {{ $attributes->merge(['class' => 'card']) }}>
    @isset($img)
        <img loading="lazy" {!! $img->attributes !!}>
    @endisset
    <div class="content">
        <h4 class="heading">{!! $title !!}</h4>
        <p class="long-text">{!! Str::inlineMarkdown($slot) !!}</p>
        @isset($htmlcontent)
            {!! $htmlcontent !!}
        @endisset
        <div class="helper_grow"></div>
        @isset($button)
            <a {!! $button->attributes !!} class="button">
                {!! $button !!}
            </a>
        @endisset
    </div>
</article>