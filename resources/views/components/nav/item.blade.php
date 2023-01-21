@php
    $route = $attributes->get('route');
@endphp
<div class="nav-item {{ Request::routeIs($route) ? 'nav-item-active' : '' }}" {{ $attributes->except(['route']) }}>
    <a href="{{ route($route) }}">{{ $slot }}</a>
</div>