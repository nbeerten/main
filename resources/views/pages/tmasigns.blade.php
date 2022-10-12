<x-layout.app title="Home" bodyscripts="<script defer src='{{ mix('/js/TMASigns.js', 'dist') }}'></script>">
    <section class="default-page tmasigns">
        <h3 class="heading">TMA Sign Generator</h3>
        <div class="two-col no-scrollbar"
             x-data="{ text: '', subtext: '', size: '2', subtextlocation: 'bottom' }"
             @@input.debounce.500ms="TMASigns.updatePreview($data)">
            
             <section class="left-col">
                <div class="input">
                    <label for="text">Text</label>
                    <input x-model="text" id="text" type="text" placeholder="Type here...">
                </div>

                <div class="input">
                    <label for="subtext">Subtext</label>
                    <input x-model="subtext" id="subtext" type="text" placeholder="Subtext">
                </div>
                      
                <div class="input">
                    <label for="size">Sign size</label>
                    <select x-model="size" id="size">
                        <option value="1">1x1</option>
                        <option value="2" selected>2x1</option>
                        <option value="4">4x1</option>
                        <option value="6">6x1</option>
                    </select>
                </div>

                <details class="options">
                    <summary>Options</summary>
                    <div class="input">
                        <label for="subtextlocation">Subtext Location</label>
                        <select x-model="subtextlocation" id="subtextlocation">
                            <option value="bottom" selected>Bottom</option>
                            <option value="top">Top</option>
                        </select>
                    </div>
                </details>

                <div class="wrapper-button-align-right">
                    <a id="downloadButton" href="" @@click.prevent.throttle.500ms="TMASigns.downloadTGA($data)" download="tma_sign2x1_text.zip" class="button">Download TGA</a>
                </div>
            </section>
            <section class="right-col">
                <div class="preview-image">
                    <img id="previewImage" src="" onclick="window.open(this.getAttribute('src'));">
                </div>
                
                <details class="json-debug">
                    <summary class="heading">JSON Data</summary>
                    <p class="description">Send POST requests to <span class="inline-code">/api/tmasigns</span></p>
                    <code id="jsondebug" class="code"></code>
                </details>
            </section>
        </div>
        <hr>
        <h4>Pre-made Packages</h4>
        <div class="card-row no-scrollbar">
            <div class="card">
                <img loading="lazy" src="{{ asset('assets/tmasigns_checkpointpack.jpg') }}" alt="Sign preview">
                <div class="content">
                    <h4 class="heading">Checkpoint numbers</h4>
                    <p class="long-text">A pre-made package containing numbered checkpoint signs from 1 to 25.</p>
                </div>
                <a href="https://github.com/nbeerten/tmasigns" class="button">Download package</a>
            </div>
            <div class="card">
                <img loading="lazy" src="{{ asset('assets/tmasigns_start.jpg') }}" alt="Sign preview">
                <div class="content">
                    <h4 class="heading">Common signs</h4>
                    <p class="long-text">A pre-made package containing signs in all formats, with texts like "GPS", "Start", "Finish", "Multilap", "Checkpoint" and much more.</p>
                </div>
                <a href="https://github.com/nbeerten/tmasigns" class="button">Download package</a>
            </div>
        </div>
        <hr>
        <h4>Tools</h4>
        <div class="card-row no-scrollbar locatortool">
            
             <section class="card" x-data="{ input: '' , data: ['A'] }">
                <div class="content">
                    <h4 class="heading">Locator Tool</h4>
                    <p class="long-text">Will automatically create locator files for you. One URL per line. Must have filename and extension as the last part of the url. For example: <span class="inline-code">https://domain.example/filename.zip</span>. Invalid URLs will be skipped. Locator files will be in the <span class="inline-code">.zip</span> file.</p>
                </div>
                <div class="input">
                    <div class="row">
                        <input x-model="$store.locatorTool.newUrl" id="locatortool" type="url" placeholder="URL" @@keyup.enter.prevent="$store.locatorTool.addUrl($store.locatorTool.newUrl)">
                        <button class="action button" @@click.prevent="$store.locatorTool.addUrl($store.locatorTool.newUrl)">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white">
                                <path fill-rule="evenodd" d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
                <ul class="urllist">
                    <template x-for="url, index in $store.locatorTool.urls">
                        <li><span x-text="url" x-bind:title="url"></span>
                            <div class="deletebutton">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" @@click.throttle.500ms="$store.locatorTool.deleteUrl(url)">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                        </li>
                    </template>
                </ul>

                <div class="wrapper-button-align-right">
                    <a id="locatorToolDownloadButton" href="" @@click.prevent.throttle.500ms="TMASigns.downloadLocators()" download="locators.zip" class="button">Download locators</a>
                </div>
            </section>
        </div>
    </section>

    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.store("locatorTool", {
                // The array of all messages
                urls: [],

                // The next message to add, its value is bound to the textarea field
                newUrl: "",

                // Adds the current value of `newMessage` to the array of messages
                addUrl(url) {
                    if(url == '') return;
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
</x-layout.app>