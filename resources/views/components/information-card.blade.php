<aside class="information-card" style='--accent-color: {!! $accent ?? "var(--color-info)" !!}' {{ $attributes }}>
    <div class="icon">
        @isset($icon)
        {!! $icon !!}
        @else
        <x-heroicon-s-information-circle/>
        @endisset
    </div>
    <div class="content">
        <h6>{!! $slot !!}</h6>
        @isset($more)
            <p>{!! $more !!}</p>
        @endisset
        <div>
            @isset($action)
                {!! $action !!}
            @endisset
        </div>
    </div>
</aside>