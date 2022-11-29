@php
    App\Classes\SEO\SEO::make(
        title: "Login",
        noindex: true
    );
@endphp

@push('scripts')
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
@endpush

<x-layout.app>
    <section class="default-page">
        <h3 class="heading">Login</h3>
        <div class="auth__form">
        
            @if($errors->any())
                <x-information-card accent="var(--color-error)">
                    <x-slot:icon><x-heroicon-s-exclamation-circle/></x-slot:icon>
                    <x-md>
                        Login failed
                    </x-md>
                    <x-slot:more>
                        <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </x-slot:more>
                </x-information-card>
            @endif
            <form method="POST" action="/login" class="form-card">
                @csrf

                {{-- Email Address --}}
                <div class="input">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" placeholder=" ">
                </div>

                {{-- Password --}}
                <div class="input">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password" placeholder=" " pattern="(.){8,}">
                </div>

                {{-- Remember Me --}}
                <div class="rememberme">
                    <div for="remember_me">
                        <input id="remember_me" type="checkbox" name="remember" value="1">
                        <label for="remember_me">Remember me</label>
                    </div>
                </div>

                <div class="submit-row">
                    <div class="captcha">
                        {{-- Cloudflare Turnstile Captcha --}}
                        {{ romanzipp\Turnstile\Captcha::getChallenge(theme: 'dark', action: Request::path()) }}
                    </div>
                    <button type="submit" class="button"><x-heroicon-s-lock-closed/>Log in</button>
                </div>

                <div class="bottom">
                    <a href="/forgot-password">Reset password</a>
                </div>
            </form>
        </div>
    </section>
</x-layout.app>
