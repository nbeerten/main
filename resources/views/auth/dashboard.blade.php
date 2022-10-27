<x-layout.app title="Account Dashboard">
    <section class="default-page">
        <h3 class="heading">Account Dashboard of {{ Auth::user()->name }}</h3>
            <a href="/logout" class="button">Log out</a>
            <a href="/telescope" class="button">Telescope</a>
            <p>Accounts:</p>
            <ul style="list-style-position: inside;">
                @foreach(DB::table('users')->select('name', 'email')->get()->toArray() as $user)
                    <li style="list-style-type: disc;">{{ $user->name }} | {{ $user->email }}</li>
                @endforeach
            </ul>
    </section>
</x-layout.app>
