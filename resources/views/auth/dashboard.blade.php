<x-layout.app title="Account Dashboard">
    <section class="default-page dashboard">
        <h3 class="heading">Account Dashboard</h3>
        <x-card style="max-width: 40ch; min-width: 0; margin-bottom: 1rem;">
            <x-slot:title>Welcome</x-slot:title>
            <p>Logged in as {{ Auth::user()->name }} ({{ Auth::user()->id }}), email: {{ Auth::user()->email }}</p>
            <x-slot:button href="/logout">Logout</x-slot:button>
        </x-card>
        <div class="card-row">
            <x-card>
                <x-slot:title>Apps</x-slot:title>
                <x-slot:htmlcontent>
                <div class="helper_row">
                    <a href="/telescope" target="_blank" class="button"><x-heroicon-m-sparkles/> Telescope</a>
                    <a href="/log-viewer" target="_blank" class="button"><x-heroicon-m-bars-4/> Log-Viewer</a>
                </div>
                </x-slot:htmlcontent>
            </x-card>
            <x-card>
                <x-slot:title>Accounts</x-slot:title>
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
        <x-details>
            <x-slot:summary>Summary of details</x-slot:summary>
            <x-card>
                <x-slot:title>Title</x-slot:title>
                <p>Cool paragraph ngl</p>
            </x-card>
        </x-details>       
    </section>
</x-layout.app>
