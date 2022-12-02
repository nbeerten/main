<nav class="nav">
    <div class="navbar">
        <div class="logo">
            <a href="/" tabindex="-1" aria-hidden="true"></a>
        </div>
        <div class="navitems">
            <div class="navitem {{ Request::routeIs('home') ? 'active' : '' }}">
                <a href="{{ route("home") }}">Home</a>
            </div>
            <div class="navitem {{ Request::routeIs('posts') ? 'active' : '' }}">
                <a href="{{ route("posts") }}">Posts</a>
            </div>
            <div class="navitem {{ Request::routeIs('contact') ? 'active' : '' }}">
                <a href="{{ route("contact") }}">Contact</a>
            </div>
        @if(Request::routeIs('tmasigns'))
            <div class="navitem {{ Request::routeIs('tmasigns') ? 'active' : '' }}">
                <a href="{{ route("tmasigns") }}">TMA Signs</a>
            </div>
        @endif
            <div class="helper_grow"></div>
        @auth
            <div class="navitem dashboard {{ Request::routeIs('auth.dashboard') ? 'active' : '' }}">
                <a href="{{ route("auth.dashboard") }}"><x-heroicon-m-user-circle/><span class="navitem__text">Dashboard</span></a>
            </div>
        @endauth
        </div>
    </div>
</nav>