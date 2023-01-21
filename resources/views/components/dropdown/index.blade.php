<div x-data="{ open: false }" @click.away="open = false" {{ $attributes }}>
    <div @click="open = ! open" {{ $trigger->attributes }}>
        {{ $trigger }}
    </div>

    <div x-bind:data-show="open" {{ $slot->attributes }} :class="open ? 'expanded' : ''">
        {{ $slot }}
    </div>
</div>