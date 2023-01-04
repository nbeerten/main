@php
    App\Classes\SEO\SEO::make(
        title: "Reset password",
        noindex: true
    );
@endphp

@push('scripts')
    @turnstileScripts()
@endpush

<x-app>
    <section class="default-page">
        <h3 class="heading">Reset password</h3>
        <div class="auth__form">
        
            @if (session('status'))
                <x-information-card accent="var(--color-success)">
                    <x-slot:icon><x-heroicon-s-check/></x-slot:icon>
                    <x-md>
                        Successfully reset the password
                    </x-md>
                </x-information-card>
            @endif
            @if($errors->any())
                <x-information-card accent="var(--color-error)">
                    <x-slot:icon><x-heroicon-s-exclamation-circle/></x-slot:icon>
                    <x-md>
                        An error occurred
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
            <form method="POST" action="/reset-password" class="form-card">
                @csrf

                {{-- Email Address --}}
                <div class="input">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ Request::query('email') }}" required autofocus autocomplete="email" placeholder=" ">
                </div>

                {{-- Password --}}
                <div class="input">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password" placeholder=" " pattern="(.){8,}">
                </div>

                {{-- Password Confirmation --}}
                <div class="input">
                    <label for="password_confirmation">Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder=" " pattern="(.){8,}">
                </div>

                <input id="token" type="hidden" name="token" value="{{ request()->route('token') }}">

                <div class="submit-row">
                    <div class="captcha">
                        {{-- Cloudflare Turnstile Captcha --}}
                        <x-turnstile data-action="reset-password" data-theme="dark" />
                    </div>
                    <button type="submit" class="button"><x-heroicon-s-paper-airplane/> Submit</button>
                </div>
            </form>
        </div>
    </section>
</x-app>
