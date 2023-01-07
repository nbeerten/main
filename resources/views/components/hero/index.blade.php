<div class="hero" {{ $attributes->only('style') }} 
    x-data x-intersect:leave.margin.-64px.0.0.0="$dispatch('darkennavbar', true)"
    x-intersect:enter.margin.-64px.0.0.0="$dispatch('darkennavbar', false)">
    <div class="hero__background-component hero__glow-1"></div>
    <div class="hero__background-component hero__glow-2"></div>
    <div class="hero__background-component hero__glow-3"></div>
</div>