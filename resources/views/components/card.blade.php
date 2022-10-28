<article {{ $attributes->merge(['class' => 'card']) }}>
    @isset($img)
        <img loading="lazy" {!! $img->attributes !!}>
    @endisset
    <div class="content">
        @isset($title)
            <h4 class="heading">{!! $title !!}</h4>
        @endisset
        <p class="long-text">{!! $slot !!}</p>
        @isset($htmlcontent)
            {!! $htmlcontent !!}
        @endisset
        <div class="helper_grow"></div>
        @isset($action)
            {!! $action !!}
        @else
        @isset($button)
            <a {!! $button->attributes !!} class="button">
                {!! $button !!}
            </a>
        @endisset
        @endisset
    </div>
</article>