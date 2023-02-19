<div id="navMobileWrapper" class="nav-mobile-wrapper" 
    x-show="expanded" x-collapse x-cloak
    x-on:click.outside="expanded = false"
    x-on:resize.window="mobile = window.matchMedia('(max-width: 767px)').matches"> 
    <div class="nav-mobile">
        {!! $slot !!}
    @auth
        <div class="nav-account-mobile">
            <a href="/dashboard" class="nav-account-picture"><img src="https://github.com/{{ Auth::user()->github_username }}.png" alt="Profile picture of {{ Auth::user()->name }}" /></a>
            <a href="/dashboard"><x-tabler-user-circle /></a>
            <a href="/telescope" target="_blank"><x-tabler-sparkles /></a>
            <a href="/log-viewer" target="_blank"><x-tabler-file-text /></a>
            <a href="https://analytics.nilsbeerten.nl/websites/ad9a9ebf-feb9-4204-88ef-1c11b9834ee5" target="_blank"><x-tabler-graph /></a>
            <x-logout><x-tabler-logout /></x-logout>
        </div>
    @endauth
    </div>
</div>