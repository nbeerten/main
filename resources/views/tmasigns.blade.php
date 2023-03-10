@push('scripts')
    @vite('resources/scripts/pages/TMASigns.ts')

    <script nonce="{{ csp_nonce() }}">
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

<x-app>
    <section class="default-page tmasigns">
        <h1 class="heading">
            <svg aria-label="TMA" alt="TMA" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 950 290" nonce="{{ csp_nonce() }}">
                <defs>
                    <style nonce="{{ csp_nonce() }}">
                        .cls-1 {
                            fill: #fff;
                            fill-rule: evenodd;
                        }
                    </style>
                </defs>
                <g id="A">
                    <path class="cls-1" d="M585,280L720,10h80l135,270h-100l-20-40h-100l35-70h30l-20-40-75,150h-100Z"></path>
                </g>
                <g id="M">
                    <path class="cls-1" d="M175,280h120l75-150,75,150h60l75-150,35,70,50-100-45-90h-80l-65,130L410,10h-80l-100,200h-20l-35,70Z">
                    </path>
                </g>
                <g id="T">
                    <path class="cls-1" d="M65,280L160,90H15L55,10H320l-40,80h-20l-95,190H65Z"></path>
                </g>
            </svg>
            Signs
        </h1>

        <x-card class="tmasigns__signpack-card">
            <x-slot:img><x-image class="card-img" src="tma_signpack_thumb.webp" alt="Sign preview" height="160" /></x-slot:img>
            <h4 class="card-title">TMA Signpack V2</h4>
            <x-markdown class="card-text" style="--line-clamp: 10">
                    The main signpack includes lots of arrow signs made by Juice, checkpoint numbers `1-25` for `6x1` signs, and common text
                    such as 'Start', 'Checkpoint', 'Multilap' and 'Finish'.
                    **More information can be found in the TMA Discord Server**
            </x-markdown>

            <x-slot:footer>
                <a class="button" href="https://discord.gg/7ZJDGAFDJv" role="button">
                    <x-tabler-download /> Download from the TMA discord
                </a>
            </x-slot:footer>
        </x-card>

        <hr>

        <x-accordion expanded>
            <x-slot:title id="generator">
                <x-tabler-photo-edit /> Sign Generator
            </x-slot:title>
            <div class="two-col no-scrollbar" x-data="TMASignsData" x-init="TMASigns.updatePreview($data)"
                x-on:input.debounce.500ms="TMASigns.updatePreview($data)" x-on:input="TMASigns.startLoadingAnimation($data)">
                <section class="left-col" role="form">
                    <div class="input">
                        <label for="text">Text</label>
                        <input id="text" type="text" pattern="^.{0,32}" placeholder="Big text" x-model="text">
                    </div>

                    <div class="input">
                        <label for="subtext">Subtext (Optional)</label>
                        <div class="row">
                            <input id="subtext" type="text" pattern="^.{0,64}" placeholder="Subtext" x-model="subtext">
                            <select id="subtextlocation" x-model="subtextlocation">
                                <option value="bottom" selected>Bottom</option>
                                <option value="top">Top</option>
                            </select>
                        </div>
                    </div>

                    <div class="input">
                        <label for="size">
                            Sign size
                        </label>
                        <select id="size" style="font-family: var(--font-mono);" x-model.number="size">
                            <option value="1">1x1</option>
                            <option value="2" selected>2x1</option>
                            <option value="4">4x1</option>
                            <option value="6">6x1</option>
                        </select>
                    </div>

                    <hr>

                    <x-accordion.card>
                        <x-slot:title>Advanced Options</x-slot:title>
                        <div class="helper_row --between">
                            <div class="input">
                                <label for="offsetText">Text offset</label>
                                <input id="offsetText" type="number" max="200" min="-200" placeholder="0" x-model.number="offsetText">
                            </div>

                            <div class="input">
                                <label for="offsetSubtext">Subtext offset</label>
                                <input id="offsetSubtext" type="number" placeholder="0" x-model.number="offsetSubtext">
                            </div>
                        </div>
                        <div class="input">
                            <label for="outlineModifier">Outline modifier</label>
                            <input id="outlineModifier" type="number" placeholder="0" x-model.number="outlineModifier">
                        </div>
                    </x-accordion.card>

                    <div class="wrapper-button-align-right">
                        <a class="button" id="downloadButton" role="button"
                            @@click.prevent.throttle.500ms="TMASigns.downloadsign($data)">
                            <x-tabler-file-download /> Download
                        </a>
                    </div>
                </section>
                <section class="right-col">
                    <div class="preview-image" data-status-message="" data-status="">
                        <x-image id="previewImage" alt="Example sign" src="default_sign.webp" draggable="false" onclick="preventDefault()" />
                    </div>

                    <x-accordion.card class="json-debug">
                        <x-slot:title>
                            <x-tabler-code />Debug information
                        </x-slot:title>
                        <button x-on:click="sessionStorage.clear()" class="button">Clear session storage</button>
                        <pre><code class="language-json" id="jsondebug"></code></pre>
                    </x-accordion.card>

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
            </div>
        </x-accordion>

        <hr>

        <x-accordion>
            <x-slot:title id="tools">
                <x-tabler-tools /> Tools
            </x-slot:title>
            <div class="card-row locatortool">
                <section class="locatortoolcard" x-data="{ input: '', data: ['A'] }">
                    <div class="content">
                        <h4 class="heading">Locator Tool</h4>
                        <p class="long-text">
                            <x-md>
                                Will automatically create locator files for you. One URL per line. Must have filename and extension as the last part
                                of the
                                url. For example: `https://domain.example/filename.zip`. Invalid URLs will be skipped. Locator files will be in
                                the `.zip` file.
                            </x-md>
                        </p>
                    </div>
                    <div class="input">
                        <div class="row">
                            <input id="locatortool" type="url"
                                @@keyup.enter.prevent="$store.locatorTool.addUrl($store.locatorTool.newUrl)" placeholder="URL"
                                x-model="$store.locatorTool.newUrl">
                            <button class="action button" @@click.prevent="$store.locatorTool.addUrl($store.locatorTool.newUrl)">
                                <x-tabler-plus stroke-width="2.5" />
                            </button>
                        </div>
                    </div>
                    <ul class="urllist">
                        <template x-for="url, index in $store.locatorTool.urls">
                            <li><span x-bind:title="url" x-text="url"></span>
                                <div class="deletebutton">
                                    <svg @@click.throttle.500ms="$store.locatorTool.deleteUrl(url)" fill="none"
                                        stroke-width="3" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </li>
                        </template>
                    </ul>

                    <div class="wrapper-button-align-right">
                        <a class="button" id="locatorToolDownloadButton" href=""
                            @@click.prevent.throttle.500ms="TMASigns.downloadLocators()" download="locators.zip">Download
                            locators</a>
                    </div>
                </section>
            </div>
        </x-accordion>
    </section>
</x-app>
