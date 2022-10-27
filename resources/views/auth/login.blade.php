<x-layout.app title="Login">

    <section class="default-page">
        <h3 class="heading">Login</h3>
        <div class="login__form">
        
        @if($errors->any())
            <div class="loginerror">
                <x-heroicon-s-exclamation-circle/>
                <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="/login">
            @csrf

            <!-- Email Address -->
            <div class="input">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>

            <!-- Password -->
            <div class="input">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password">
            </div>

            <!-- Remember Me -->
            <div class="rememberme">
                <div for="remember_me">
                    <input id="remember_me" type="checkbox" name="remember" value="1">
                    <label for="remember_me">Remember me</label>
                </div>
            </div>

            <div>
                <button type="submit" class="button">Log in</button>
            </div>
        </form>
    </section>
</x-layout.app>
