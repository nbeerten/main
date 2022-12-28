<details {{ $attributes->merge(['class' => 'component_details-card']) }}>
    <summary {{ $summary->attributes }}>
        {!! $summary !!}
    </summary>
    <div class="component_details-card__content">
        {!! $slot !!}
    </div>
</details>