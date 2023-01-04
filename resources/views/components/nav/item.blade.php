@php
    $route = $attributes->get('route');
@endphp
<div class="navitem {{ Request::routeIs($route) ? 'active' : '' }}" {{ $attributes->except(['route']) }}>
    <a href="{{ route($route) }}">{{ $slot }}</a>
</div>