<div {{ $attributes->merge(['class' => 'card']) }}>
    <div class="card-body">
        {!! $slot !!}
        <div class="helper_grow"></div>
        @isset($footer)
            <div {{ $footer->attributes->merge(['class' => 'card-footer']) }}>
                {!! $footer !!}
            </div>
        @endisset
    </div>
</div>
