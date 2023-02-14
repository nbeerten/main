<div {{ $attributes->merge(['class' => 'card']) }}>
    @isset($img)
        <img class="card-img" loading="lazy" {{ $img->attributes }}>
    @endisset
    <div class="card-body">
        {{  $slot  }}
        <div class="helper_grow"></div>
    </div>
    @isset($footer)
        <div {{ $footer->attributes->merge(['class' => 'card-footer']) }}>
            {!! $footer !!}
        </div>
    @endisset
</div>
