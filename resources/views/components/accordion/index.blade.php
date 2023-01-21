@php
    use Illuminate\Support\Str;
 
    $uid = Str::random(10);
    
    $expanded = !empty($attributes->get('expanded')) ? 'true' : 'false';
    $headingLevel = !empty($attributes->get('h')) ? 'h' . $attributes->get('h') : "h3";
    $animationDuration = !empty($attributes->get('animation-duration')) ? $attributes->get('animation-duration') : "200ms";
@endphp

<div class="accordion"
     x-data="{ expanded: {{ $expanded }} }">
    <{!! $headingLevel !!} class="accordion-h" {{ $title->attributes }}>
        <button type="button"
                aria-controls="accordion_content_{{ $uid }}"
                id="accordion_{{ $uid }}"
                x-on:click="expanded = !expanded"
                :aria-expanded="expanded ? true : false"
                class="accordion-trigger">
            <span>
                {!! $title !!}
            </span>
        </button>
    </{!! $headingLevel !!}>
    <div id="accordion_content_{{ $uid }}"
         role="region"
         aria-labelledby="accordion_{{ $uid }}"
         x-show="expanded" 
         x-collapse.duration.{{ $animationDuration }}
         class="accordion-body">
        
            {!! $slot !!}

    </div>
</div>