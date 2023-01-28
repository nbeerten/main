@push('scripts')
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
@endpush

<x-app>
    <section class="default-page">
        <h1 class="heading">Contact</h1>
        <div class="form-wrapper">
            <form method="POST" action="" class="form-card contact">
                @csrf

                @if (session()->has('success'))
                    <x-information-card accent="var(--color-success)">
                        <x-slot:icon>
                            <x-heroicon-s-check />
                        </x-slot:icon>
                        <x-md>
                            {{ session()->get('success', "Successfully send the message!"); }}
                        </x-md>
                    </x-information-card>
                @endif
                @if($errors->any())
                    <x-information-card accent="var(--color-error)">
                        <x-slot:icon>
                            <x-heroicon-s-exclamation-circle />
                        </x-slot:icon>
                        <x-md>
                            Error!
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

                <div class="form-grid">
                    <div class="input name">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Name" maxlength="128" required="true">
                    </div>

                    <div class="input email">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="example@domain.tld" required="true">
                    </div>

                    <div class="input subject">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject" value="{{ old('subject') }}" placeholder="Subject" maxlength="64" required="true">
                    </div>

                    <div class="input message">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" rows="5" placeholder="Message" required="true">{{ old('message') }}</textarea>
                    </div>

                    <div class="submit-row">
                        <div class="captcha">
                            {{-- Cloudflare Turnstile Captcha --}}
                            <x-turnstile data-action="contact" data-theme="dark" />
                        </div>
                        <button type="submit" class="button">
                            <x-heroicon-s-paper-airplane />Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</x-app>
