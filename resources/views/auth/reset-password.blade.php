@push('scripts')
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer nonce="{{ csp_nonce() }}"></script>
@endpush

<x-app>
    <section class="default-page">
        <h3 class="heading">Reset password</h3>
        <div class="form-wrapper">
        
            @if (session('status'))
                <x-information-card accent="var(--color-success)">
                    <x-slot:icon><x-tabler-checks /></x-slot:icon>
                    <x-md>
                        Successfully reset the password
                    </x-md>
                </x-information-card>
            @endif
            @if($errors->any())
                <x-information-card accent="var(--color-error)">
                    <x-slot:icon><x-tabler-exclamation-circle /></x-slot:icon>
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
                    <button type="submit" class="button"><x-tabler-send /> Submit</button>
                </div>
            </form>
        </div>
    </section>
</x-app>
