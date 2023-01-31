<nav class="nav" x-data="{
    expanded: false,
    mobile: window.matchMedia('(max-width: 767px)').matches
}">
    <div class="nav-bar">
        <div class="nav-logo">
            <a href="/" tabindex="-1" aria-hidden="true"></a>
        </div>
        <x-nav.navitems-desktop />
        <x-nav.navitems-mobile />
        <div class="helper_grow"></div>
        <div class="nav-toggle" x-show="mobile" x-cloak>
            <button x-on:click="expanded = !expanded">
                <x-heroicon-s-bars-3 />
            </button>
        </div>
    </div>
</nav>
