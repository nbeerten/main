<div class="navitems--mobile__wrapper" 
    x-show="expanded" x-collapse x-cloak
    x-on:click.outside="expanded = false"
    x-on:resize.window="mobile = window.matchMedia('(max-width: 767px)').matches"> 
    <div class="navitems--mobile">
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
    @auth
        <div class="account-buttons">
            <a href="/dashboard" class="profile-picture"><img src="/storage/{{ Auth::user()->avatar }}" alt="Profile picture of {{ Auth::user()->name }}" /></a>
            <a href="/dashboard"><x-heroicon-m-user-circle /></a>
            <a href="/telescope" target="_blank"><x-heroicon-m-sparkles/></a>
            <a href="/log-viewer" target="_blank"><x-heroicon-m-bars-4/></a>
            <a href="/cp" target="_blank"><x-simpleicon-statamic class="heroicons" /></a>
            <x-logout><x-heroicon-m-arrow-left-on-rectangle/></x-logout>
        </div>
    @endauth
    </div>
</div>