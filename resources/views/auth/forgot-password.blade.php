@php
    App\Classes\SEO\SEO::make(
        title: "Forgot password",
        noindex: true
    );
@endphp

@push('scripts')
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
@endpush

<x-app>
    <section class="default-page">
        <h3 class="heading">Forgot password</h3>
        <div class="auth__form">
        
            @if (session('status'))
                <x-information-card accent="var(--color-success)">
                    <x-slot:icon><x-heroicon-s-check/></x-slot:icon>
                    <x-md>
                        Successfully send the reset link
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
            <form method="POST" action="/forgot-password">
                @csrf

                {{-- Email Address --}}
                <div class="input">
                    <label for="email">Email</label>
                    <input id="email" type="email" value="{{ old('email') }}" name="email" required autofocus placeholder=" ">
                </div>

                <div class="submit-row">
                    <div class="captcha">
                        {{-- Cloudflare Turnstile Captcha --}}
                        {{ romanzipp\Turnstile\Captcha::getChallenge(theme: 'dark', action: Request::path()) }}
                    </div>
                    <button type="submit" class="button"><x-heroicon-s-paper-airplane/>Submit</button>
                </div>
            </form>
        </div>
    </section>
</x-app>
