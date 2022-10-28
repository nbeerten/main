@push('scripts')
    <script defer src='{{ mix('/js/TMASigns.js', 'dist') }}'></script>
    <script defer src='{{ mix('/js/prism.js', 'dist') }}'></script>

    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.store("locatorTool", {
                // The array of all messages
                urls: [],

                // The next message to add, its value is bound to the textarea field
                newUrl: "",

                // Adds the current value of `newMessage` to the array of messages
                addUrl(url) {
                    if (url == '') return;
                    this.urls.push(url);
                    this.newUrl = "";
                },

                // Given an index, removes the message from the array
                deleteUrl(index) {
                    this.urls = this.urls.filter(i => i !== index);
                },
            });
        });
    </script>
@endpush

<x-layout.app title="TMA Signs">
    <x-slot:opengraph img="{{ asset('assets/og/tmasigns@630.jpg') }}">
        Small web application to create signs for the game Trackmania with user input as text on the image, styled to fit in with the TMA signpack.
    </x-slot:opengraph>

    <section class="default-page tmasigns">
        <h3 class="heading">TMA Signs</h3>
        <x-details open>
            <x-slot:summary id="packages">
                <x-heroicon-s-archive-box /> Pre-made Packages
            </x-slot:summary>
            <div class="card-row">
                <x-card class="card-top">
                    <x-slot:img src="{{ asset('assets/tma_sign6x1_Checkpoint 7.jpg') }}" alt="Sign preview"></x-slot:img>
                    <x-slot:title>Checkpoint numbers</x-slot:title>
                    <x-md>
                        A pre-made package containing numbered checkpoint signs from 1 to 25. Only in the `6x1` size (sign size used on checkpoints, start and finish).
                    </x-md>

                    <x-slot:button href="https://github.com/nbeerten/tmasigns">
                        <x-heroicon-s-archive-box-arrow-down defer /> Download package
                    </x-slot:button>
                </x-card>
                <x-card class="card-top">
                    <x-slot:img src="{{ asset('assets/tma_sign6x1_start.jpg') }}" alt="Example of sign"></x-slot:img>
                    <x-slot:title>Common signs</x-slot:title>
                    <x-md>A pre-made package containing signs in all formats, with texts like "GPS", "Start", "Finish", "Multilap", "Checkpoint" and much more.</x-md>

                    <x-slot:button href="https://github.com/nbeerten/tmasigns">
                        <x-heroicon-s-archive-box-arrow-down defer /> Download package
                    </x-slot:button>
                </x-card>
            </div>
        </x-details>
        <hr>
        <x-details open>
            <x-slot:summary id="generator">
                <x-heroicon-s-beaker /> Sign Generator
            </x-slot:summary>
            <div class="two-col no-scrollbar" x-data="{ text: '', subtext: '', size: '2', subtextlocation: 'bottom' }" @@input.debounce.500ms="TMASigns.updatePreview($data)">

                <section class="left-col">
                    <div class="input">
                        <label for="text">Text</label>
                        <input x-model="text" id="text" type="text" placeholder="Big text">
                    </div>

                    <div class="input">
                        <label for="subtext">Subtext (Optional)</label>
                        <div class="row">
                            <input x-model="subtext" id="subtext" type="text" placeholder="Subtext" x-bind:disabled="size == 6 ? true : false">
                            <select x-model="subtextlocation" id="subtextlocation" x-bind:disabled="size == 6 ? true : false">
                                <option value="bottom" selected>Bottom</option>
                                <option value="top">Top</option>
                            </select>
                        </div>
                    </div>

                    <div class="input">
                        <label for="size">Sign size</label>
                        <select x-model="size" id="size" class="font-mono">
                            <option value="1">1x1</option>
                            <option value="2" selected>2x1</option>
                            <option value="4">4x1</option>
                            <option value="6">6x1</option>
                        </select>
                    </div>

                    {{-- <details class="options">
                        <summary>Options</summary>
                    </details> --}}

                    <div class="wrapper-button-align-right">
                        <a id="downloadButton" href="" @@click.prevent.throttle.500ms="TMASigns.downloadTGA($data)"
                            download="tma_sign2x1_text.zip" class="button">
                            <x-heroicon-m-arrow-down-tray /> Download TGA
                        </a>
                    </div>
                </section>
                <section class="right-col">
                    <div class="preview-image" data-status="" data-status-message="">
                        <img id="previewImage" src="{{ asset('assets/default_sign.jpg') }}" onclick="window.open(this.getAttribute('src'));">
                    </div>

                    <x-details-card>
                        <x-slot:summary>
                            <x-heroicon-m-code-bracket />JSON Data
                        </x-slot:summary>
                        <p><x-md>Send POST requests to `/api/tmasigns`</x-md></p>
                        <pre><code id="jsondebug" class="language-json"></code></pre>
                    </x-details-card>
                </section>
            </div>
        </x-details>
        <hr>
        <x-details>
            <x-slot:summary id="tools">
                <x-heroicon-s-wrench /> Tools
            </x-slot:summary>
            <div class="card-row locatortool">
                <section class="locatortoolcard" x-data="{ input: '', data: ['A'] }">
                    <div class="content">
                        <h4 class="heading">Locator Tool</h4>
                        <p class="long-text"><x-md>
                            Will automatically create locator files for you. One URL per line. Must have filename and extension as the last part of the
                            url. For example: `https://domain.example/filename.zip`. Invalid URLs will be skipped. Locator files will be in
                            the `.zip` file.
                        </x-md></p>
                    </div>
                    <div class="input">
                        <div class="row">
                            <input x-model="$store.locatorTool.newUrl" id="locatortool" type="url" placeholder="URL"
                                @@keyup.enter.prevent="$store.locatorTool.addUrl($store.locatorTool.newUrl)">
                            <button class="action button" @@click.prevent="$store.locatorTool.addUrl($store.locatorTool.newUrl)">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white">
                                    <path fill-rule="evenodd"
                                        d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <ul class="urllist">
                        <template x-for="url, index in $store.locatorTool.urls">
                            <li><span x-text="url" x-bind:title="url"></span>
                                <div class="deletebutton">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor"
                                        @@click.throttle.500ms="$store.locatorTool.deleteUrl(url)">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </div>
                            </li>
                        </template>
                    </ul>

                    <div class="wrapper-button-align-right">
                        <a id="locatorToolDownloadButton" href="" @@click.prevent.throttle.500ms="TMASigns.downloadLocators()"
                            download="locators.zip" class="button">Download locators</a>
                    </div>
                </section>
            </div>
        </x-details>
    </section>
</x-layout.app>
