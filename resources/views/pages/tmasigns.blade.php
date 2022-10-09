<x-layout.app title="Home" bodyscripts="<script defer src='{{ mix('/js/TMASigns.js', 'dist') }}'></script>">
    <section class="default-page tmasigns">
        <h3 class="heading">TMASigns</h3>
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
        <div class="premade-packages no-scrollbar">
            <div class="card">
                <img loading="lazy" src="{{ asset('assets/tmasigns_Checkpoint_3.jpg') }}" alt="Sign preview">
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
    </section>
</x-layout.app>