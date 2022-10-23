<nav class="nav">
    <div>
        <div>
            <div class="logo">
                <a href="/" style="--site-logo: url({{ asset('assets/logo_white.svg') }});"></a>
            </div>
            <div class="navitem {{ Request::routeIs('home') ? 'active' : '' }}">
                <a href="{{ route("home") }}">Home</a>
            </div>
            @if(Request::routeIs('tmasigns'))
            <div class="navitem {{ Request::routeIs('tmasigns') ? 'active' : '' }}">
                <a href="{{ route("tmasigns") }}">TMA Signs</a>
            </div>
            @endif
            <div class="helper_grow"></div>
        </div>
    </div>
</nav>