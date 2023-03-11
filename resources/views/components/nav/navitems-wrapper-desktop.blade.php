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
                                <x-tabler-user-circle />
                            </a>
                            <a href="/telescope" target="_blank" class="item">
                                <x-tabler-sparkles />
                            </a>
                            <a href="/log-viewer" target="_blank" class="item">
                                <x-tabler-file-text />
                            </a>
                            <a href="https://nilsbeerten.piwik.pro/analytics/" target="_blank" class="item">
                                <x-tabler-graph />
                            </a>
                            <x-logout class="item">
                                <x-tabler-logout />
                            </x-logout>
                        </div>
                    </div>
                </div>
            </x-slot:slot>
            </x-dropdown>
        @endauth
</div>
