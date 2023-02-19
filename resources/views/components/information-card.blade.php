<aside class="information-card" style='--accent-color: {!! $accent ?? "var(--accent-info-dark)" !!}' {{ $attributes }}>
    <div class="icon">
        @isset($icon)
        {!! $icon !!}
        @else
        <x-tabler-info-circle-filled />
        @endisset
    </div>
    <div class="content">
        <h6>{!! $slot !!}</h6>
        @isset($more)
            <p>{!! $more !!}</p>
        @endisset
        @isset($action)
            <div>
                {!! $action !!}
            </div>
        @endisset
    </div>
</aside>