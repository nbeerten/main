<div class="nav-desktop">
    {!! $slot !!}
    <div class="helper_grow"></div>
    @auth
        <x-dropdown class="nav-account-desktop">
            <x-slot name="trigger" class="nav-account-toggle">
                <button><img src="https://github.com/{{ Auth::user()->github_username }}.png" alt="Profile picture of {{ Auth::user()->name }}" /></button>
            </x-slot>

            <x-slot:slot class="nav-account-body">
                <div>
                    <div>
                        <div class="nav-account-details">
                            <img src="https://github.com/{{ Auth::user()->github_username }}.png" alt="Profile picture of {{ Auth::user()->name }}" />
                            <p>{{ Auth::user()->name }}</p>
                        </div>
                        <div class="nav-account-items">
                            <a href="/dashboard" class="item">
                                <x-heroicon-m-user-circle />
                            </a>
                            <a href="/telescope" target="_blank" class="item">
                                <x-heroicon-m-sparkles />
                            </a>
                            <a href="/log-viewer" target="_blank" class="item">
                                <x-heroicon-m-bars-4 />
                            </a>
                            <a href="https://analytics.nilsbeerten.nl/websites/ad9a9ebf-feb9-4204-88ef-1c11b9834ee5" target="_blank" class="item">
                                <x-heroicon-m-chart-bar />
                            </a>
                            <x-logout class="item">
                                <x-heroicon-m-lock-closed />
                            </x-logout>
                        </div>
                    </div>
                </div>
            </x-slot:slot>
            </x-dropdown>
        @endauth
</div>
