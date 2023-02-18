<nav class="nav" x-data="{
    expanded: false,
    mobile: window.matchMedia('(max-width: 767px)').matches
}">
    <div class="nav-bar">
        <div class="nav-logo">
            <a href="/" tabindex="-1" aria-hidden="true">
                <img src="/assets/logo_white.svg" />
                <span>Nils Beerten</span>
            </a>
        </div>
        <x-nav.navitems-wrapper-desktop>
            <x-nav.navitems />
        </x-nav.navitems-wrapper-desktop>
        <x-nav.navitems-wrapper-mobile>
            <x-nav.navitems />
        </x-nav.navitems-wrapper-mobile>
        <div class="helper_grow"></div>
        <div class="nav-toggle" x-show="mobile" x-cloak x-bind:aria-hidden="!mobile">
            <button x-on:click="expanded = !expanded" aria-controls="navMobileWrapper" aria-label="Expand or collapse menu" x-bind:aria-hidden="!mobile">
                <x-heroicon-s-bars-3 />
            </button>
        </div>
    </div>
</nav>
