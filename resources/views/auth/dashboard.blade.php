@php
    App\Classes\SEO\SEO::make(
        title: "Dashboard",
        noindex: true
    );
@endphp

<x-app title="Account Dashboard" noindex="true">
    <section class="default-page dashboard">
        <h3 class="heading">Dashboard</h3>
        <x-card style="max-width: 40ch; min-width: 0; margin-bottom: 1rem;">
            <h4 class="card-title">Welcome</h4>
            <p class="card-text">Logged in as {{ Auth::user()->name }} ({{ Auth::user()->id }}), email: {{ Auth::user()->email }}</p>
            <x-slot:footer>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="button">
                        Logout
                    </button>
                </form>
            </x-slot:footer>
        </x-card>
        <div class="card-row">
            <x-card>
                <h4 class="card-title">Apps</h4>
                <x-slot:footer>
                    <div class="helper_row-wrap">
                        <a href="/telescope" target="_blank" class="button"><x-heroicon-m-sparkles/> Telescope</a>
                        <a href="/log-viewer" target="_blank" class="button"><x-heroicon-m-bars-4/> Log-Viewer</a>
                        <a href="/cp" target="_blank" class="button"><x-simpleicon-statamic class="heroicons" /> Statamic</a>
                    </div>
                </x-slot:footer>
            </x-card>
            <x-card>
                <h4 class="card-title">Accounts</h4>
                <table>
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Name</td>
                            <td>Email</td>
                        </tr>
                    </thead>
                    @foreach(DB::table('users')->select('id', 'name', 'email')->get()->toArray() as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                        </tr>
                    @endforeach
                </table>
            </x-card>
        </div> 
    </section>
</x-app>
