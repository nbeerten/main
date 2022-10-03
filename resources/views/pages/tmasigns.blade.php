<x-layout.app title="Home" bodyscripts="<script defer src='/js/pages/TMASigns.js'></script>">
    <section class="default-page tmasigns">
        <h3 class="heading">TMASigns</h3>
        <div class="two-col no-scrollbar"
             x-data="{ text: '', subtext: '', size: '2' }"
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
                <div class="wrapper-button-align-right">
                    <a id="downloadButton" href="" @@click.prevent.throttle.500ms="TMASigns.downloadTGA($data)" download="tma_sign2x1_text.zip" class="button">Download TGA</a>
                </div>
            </section>
            <section class="right-col">
                <div class="preview-image">
                    <img id="previewImage" src="">
                </div>

                <div class="json-debug">
                    <h6 class="heading">JSON Data</h6>
                    <p class="description">Send POST requests to <span class="inline-code">/api/tmasigns</span></p>
                    <code id="jsondebug" class="code"></code>
                <div>
            </section>
        </div>
    </section>
</x-layout.app>