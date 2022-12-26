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
            
            <x-ui.dropdown class="account-dropdown">
                <x-slot name="trigger" class="account-dropdown__trigger">
                    <button><img src="/storage/{{ Auth::user()->avatar }}" alt="Profile picture of {{ Auth::user()->name }}" /></button>
                </x-slot>
                
                <x-slot name="slot" class="account-dropdown__slot">
                    <div>
                        <div class="account-dropdown__items">
                            <a href="/dashboard" class="item"><x-heroicon-m-user-circle /> Dashboard</a>
                            <a href="/telescope" target="_blank" class="item"><x-heroicon-m-sparkles/> Telescope</a>
                            <a href="/log-viewer" target="_blank" class="item"><x-heroicon-m-bars-4/> Log-Viewer</a>
                            <a href="/cp" target="_blank" class="item"><x-simpleicon-statamic class="heroicons" /> Statamic</a>
                            <x-logout class="item"><x-heroicon-m-lock-closed/> Log out</x-logout>
                        </div>
                    </div>
                </x-slot>
            </x-ui-dropdown>
        @endauth
        </div>
    </div>
</nav>