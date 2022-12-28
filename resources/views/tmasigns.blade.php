@push('scripts')
    @vite('resources/scripts/pages/TMASigns.js')
    @vite('resources/scripts/prism.js')

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

<x-layout.app>
    <section class="default-page tmasigns">
        <h1 class="heading">TMA Signs</h1>

        {{-- <x-modal data-id="faq">
            <x-slot:title>
                <x-heroicon-m-question-mark-circle /> FAQ
            </x-slot:title>
            <x-details>
                <x-slot:summary>What do I do with the file?</x-slot:summary>
                <p>
                    <x-md>
                        After downloading the file you'll need to host it somewhere. This website intentionally never allows you to use it as hosting for the signs,
                        because signs need to be hosted on servers that are able to handle thousands of requests at the same moment for events such as cup of the day.
                        Currently the best option is to host signs on Discord:
                        <br><br>
                        Hosting a sign on Discord is relatively easy. The first step is to send the file(s) in a channel in **any** Discord server. All Discord
                        servers are "public", so even your own server with a single member will work. After uploading the file(s), you have to copy the url to
                        them. This is not the same as copying the URL of the message, so pay attention to that. The URL should end with `.tga` or `.zip`.
                        <br><br>
                        After copying the URL, you can go to the map editor and select the skinning tool (the bucket icon). Then click the "Custom URL" button and paste
                        the URL to the sign there. Then click "OK", and if you did it correctly, it should now show up!
                    </x-md>
                </p>
            </x-details>
        </x-modal> --}}
        <x-details open>
            <x-slot:summary id="packages">
                <x-heroicon-s-archive-box /> TMA Signpack
            </x-slot:summary>
            <x-card class="tmasigns__signpack-card">
                <x-slot:img src="{{ asset('assets/tmasigns_signpack_thumb.webp') }}" alt="Sign preview" height="160" width="500"></x-slot:img>
                <x-slot:title>The TMA Signpack</x-slot:title>
                <x-md>
                    The main signpack includes: arrow signs made by Juice, checkpoint numbers `1-25` for `6x1` signs, and common text
                    such as: 'Start', 'Checkpoint', 'Multilap' and 'Finish'.
                    **More information can be found in the TMA Discord Server**
                </x-md>

                <x-slot:action>
                    <a href="https://discord.gg/b8MfZsYFWg" class="button" role="button">
                        <x-simpleicon-discord class="heroicons" /> TMA Discord Server
                    </a>
                    <a href="{{-- https://cdn.discordapp.com/attachments/1025895091782565898/1057230647502049351/TMA-signs-pack-v2.zip --}}" class="button" role="button" disabled>
                        <x-heroicon-s-archive-box-arrow-down defer /> Download signpack
                    </a>
                </x-slot:action>
            </x-card>
        </x-details>
        
        <hr>

        <x-details open>
            <x-slot:summary id="generator">
                <x-heroicon-s-beaker /> Sign Generator
            </x-slot:summary>
            <div class="two-col no-scrollbar" 
                 x-data="{ text: '', subtext: '', size: '2', subtextlocation: 'bottom', offsetText: '0', offsetSubtext: '0' }" 
                 @@input.debounce.500ms="TMASigns.updatePreview($data)">

                <section class="left-col" role="form">
                    <div class="input">
                        <label for="text">Text</label>
                        <input x-model="text" id="text" type="text" placeholder="Big text">
                    </div>

                    <div class="input">
                        <label for="subtext">Subtext (Optional)</label>
                        <div class="row">
                            <input x-model="subtext" id="subtext" type="text" placeholder="Subtext">
                            <select x-model="subtextlocation" id="subtextlocation">
                                <option value="bottom" selected>Bottom</option>
                                <option value="top">Top</option>
                            </select>
                        </div>
                    </div>

                    <div class="input">
                        <label for="size">
                            Sign size
                        </label>
                        <select x-model="size" id="size" style="font-family: var(--font-mono);">
                            <option value="1">1x1</option>
                            <option value="2" selected>2x1</option>
                            <option value="4">4x1</option>
                            <option value="6">6x1</option>
                        </select>
                    </div>

                    <x-details-card>
                        <x-slot:summary>Options</x-slot:summary>
                        <div class="helper_row --between">
                            <div class="input">
                                <label for="offsetText">Text offset</label>
                                <input x-model="offsetText" id="offsetText" type="number" placeholder="0" min="-200" max="200">
                            </div>

                            <div class="input">
                                <label for="offsetSubtext">Subtext offset</label>
                                <input x-model="offsetSubtext" id="offsetSubtext" type="number" placeholder="0">
                            </div>
                        </div>
                    </x-details-card>

                    <div class="wrapper-button-align-right">
                        <a id="downloadButton" href="" @@click.prevent.throttle.500ms="TMASigns.downloadsign($data)"
                            download="tma-text-text-subtext_4x1-UG.zip" class="button" role="button">
                            <x-heroicon-m-arrow-down-tray /> Download
                        </a>
                    </div>

                    <div class="tmasigns__information-card">
                        <x-information-card>
                            <x-md>Did you find a bug, need help or have feedback?</x-md>
                            <x-slot:more>
                                Feel free to report, ask or share it with me by sending me a DM on discord (nbert#2620).
                                In case you need a large amount of signs with e.g. incremental numbers feel free to contact me as well.
                            </x-slot:more>
                        </x-information-card>
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
                        <p>
                            <x-md>Send POST requests to `/api/tmasigns`</x-md>
                        </p>
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
                        <p class="long-text">
                            <x-md>
                                Will automatically create locator files for you. One URL per line. Must have filename and extension as the last part of the
                                url. For example: `https://domain.example/filename.zip`. Invalid URLs will be skipped. Locator files will be in
                                the `.zip` file.
                            </x-md>
                        </p>
                    </div>
                    <div class="input">
                        <div class="row">
                            <input x-model="$store.locatorTool.newUrl" id="locatortool" type="url" placeholder="URL"
                                @@keyup.enter.prevent="$store.locatorTool.addUrl($store.locatorTool.newUrl)">
                            <button class="action button" @@click.prevent="$store.locatorTool.addUrl($store.locatorTool.newUrl)">
                                <x-heroicon-o-plus stroke-width="2.5" />
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
    <script>
        // Auto close all other tools when hash = generator; script placed here to prevent flickering
        if(window.location.hash == "#generator") {
            const elements = document.querySelectorAll(`details[open] > summary:not(#generator)`);
            elements.forEach(element => {
                element.parentNode.removeAttribute('open');
            })
        }
    </script>
</x-layout.app>
