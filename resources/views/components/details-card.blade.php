<details {{ $attributes->merge(['class' => 'component_details-card']) }}>
    <summary {{ $summary->attributes }}>
        {!! $summary !!}
    </summary>
    {!! $slot !!}
</details>