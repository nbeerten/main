@php
    use Illuminate\Support\Str;
 
    $uid = Str::random(10);
    
    $expanded = !empty($attributes->get('expanded')) ? 'true' : 'false';
    $animationDuration = !empty($attributes->get('animation-duration')) ? $attributes->get('animation-duration') : "200ms";
@endphp

<div {{ $attributes->merge(['class' => 'accordioncard']) }}
     x-data="{ expanded: {{ $expanded }} }">
    <button type="button"
            aria-controls="accordion_content_{{ $uid }}"
            id="accordion_{{ $uid }}"
            x-on:click="expanded = !expanded"
            :aria-expanded="expanded ? true : false"
            class="accordioncard-trigger">
        <span>
            {!! $title !!}
        </span>
    </button>
    <div id="accordion_content_{{ $uid }}"
         role="region"
         aria-labelledby="accordion_{{ $uid }}"
         x-show="expanded" 
         x-collapse.duration.{{ $animationDuration }}
         class="x-accordion-card__content"
         {{ $expanded == 'false' ? 'x-cloak' : '' }}>
        <div class="accordioncard-inner">
            {!! $slot !!}
        </div>
    </div>
</div>