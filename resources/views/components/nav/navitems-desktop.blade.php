<div class="navitems--desktop">
    <x-nav.item route="home">
        Home
    </x-nav.item>
    <x-nav.item route="posts">
        Posts
    </x-nav.item>
    <x-nav.item route="contact">
        Contact
    </x-nav.item>
@if(Request::routeIs('tmasigns'))
    <x-nav.item route="tmasigns">
        TMA Signs
    </x-nav.item>
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