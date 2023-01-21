<div {{ $attributes->merge(['class' => 'card card-post']) }}>
    @isset($img)
        <img class="card-img" loading="lazy" {{ $img->attributes }}>
    @endisset
    <div class="card-body">
        <h4 class="card-title">{{ $title }}</h4>
        <p class="card-text">
            <x-md>
                {{ $slot }}
            </x-md>
        </p>
        <div class="helper_grow"></div>
        <div class="card-footer">
            {!! $footer !!}
        </div>
    </div>
</div>
