<article {{ $attributes->merge(['class' => 'card']) }}>
    @isset($img)
        <img class="card__img" loading="lazy" {!! $img->attributes !!}>
    @endisset
    <div class="card__content">
        @isset($title)
            <h4 class="card__heading">{!! $title !!}</h4>
        @endisset
        <p class="card__long-text">{!! $slot !!}</p>
        @isset($htmlcontent)
            {!! $htmlcontent !!}
        @endisset
        <div class="helper_grow"></div>
        @if(isset($action) || isset($button))
        <hr>
        @endisset
        <div class="card__action">
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
    </div>
</article>