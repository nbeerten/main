@php
    App\Classes\SEO\SEO::make(
        title: "Contact",
        noindex: false
    );
@endphp

@push('scripts')
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
@endpush

<x-layout.app>
    <section class="default-page">
        <h3 class="heading">Contact</h3>
        <div class="contact__form">
            <form method="POST" action="/!/forms/contact" class="form-card contact">
                @php( $statamic = Statamic::tag('form:contact'))
                @csrf
                
                @if($statamic->success)
                <x-information-card accent="var(--color-success)">
                    <x-slot:icon><x-heroicon-s-check/></x-slot:icon>
                    <x-md>
                        Successfully send the message!
                    </x-md>
                </x-information-card>
                @elseif($statamic->errors)
                    <x-information-card accent="var(--color-error)">
                        <x-slot:icon><x-heroicon-s-exclamation-circle/></x-slot:icon>
                        <x-md>
                            Error!
                        </x-md>
                        <x-slot:more>
                            <ul>
                            @foreach ($statamic->errors as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                            </ul>
                        </x-slot:more>
                    </x-information-card>
                @endif
                
                <div class="form-grid">
                    @foreach ($statamic->fields as $field)
                    <div class="input {{ $field['handle'] }}">
                        <label for="{{ $field['handle'] }}">{{ Str::title($field['handle']) }}</label>
                        {!! $field['field'] !!}
                    </div>
                    @endforeach

                    <input type="text" class="honeypot" name="{{ $statamic->honeypot ?? 'honeypot' }}">

                    <div class="submit-row">
                        <div class="captcha">
                            {{-- Cloudflare Turnstile Captcha --}}
                            {!! Statamic::tag('captcha') !!}
                        </div>
                        <button type="submit" class="button"><x-heroicon-s-paper-airplane/>Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</x-layout.app>
