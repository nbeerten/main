<x-layout.app title="Home" bodyscripts="<script defer src='/js/pages/TMASigns.js'></script>">
    <section>
        <h3 class="block py-3 text-3xl font-bold">TMASigns</h3>
        <div class="flex flex-col lg:flex-row gap-4 no-scrollbar"
             x-data="{ text: '', subtext: '', size: '2' }"
             @@input.debounce.500ms="TMASigns.updatePreview($data)">
            
             <section class="lg:w-1/2 flex flex-col gap-2">
                <div>
                    <label for="text" class="block text-sm text-gray-300">Text</label>
                    <input x-model="text" id="text" type="text" placeholder="Type here..."
                           class="mt-1 block w-full px-3 py-2 rounded-md bg-neutral-800 hover:bg-neutral-700 focus:bg-neutral-700 focus:outline-none focus-visible:ring-1 focus-visible:ring-indigo-500">
                </div>

                <div>
                    <label for="subtext" class="block text-sm text-gray-300">Subtext</label>
                    <input x-model="subtext" id="subtext" type="text" placeholder="Subtext"
                        class="mt-1 block w-full px-3 py-2 rounded-md bg-neutral-800 hover:bg-neutral-700 focus:bg-neutral-700 focus:outline-none focus-visible:ring-1 focus-visible:ring-indigo-500">
                </div>
                      
                <div>
                    <label for="size" class="block text-sm font-medium text-gray-300">Sign size</label>
                    <select x-model="size" id="size" 
                            class="mt-1 block w-full rounded-md bg-neutral-800 hover:bg-neutral-700 py-2 px-3 focus:outline-none focus-visible:ring-1 focus-visible:ring-indigo-500">
                        <option value="1">1x1</option>
                        <option value="2" selected>2x1</option>
                        <option value="4">4x1</option>
                        <option value="6">6x1</option>
                    </select>
                </div>
                <div class="w-full flex justify-end">
                    <a id="downloadButton" href="" @@click.prevent.throttle.500ms="TMASigns.downloadTGA($data)" download="tma_sign2x1_text.zip" class="bg-neutral-800 hover:bg-neutral-700 rounded-md px-3 py-2 w-max">Download TGA</a>
                </div>
            </section>
            <section class="lg:w-1/2 flex flex-col gap-4">
                <div class="min-h-[200px] max-h-96 grid place-content-center bg-gray-700 rounded-md relative after:content-['Preview'] after:absolute after:top-0 after:left-0 after:bg-black after:px-2 after:py-1 after:rounded-tl-md after:rounded-br-md">
                    <img id="previewImage" src="" class=" max-h-96">
                </div>

                <div class="w-full flex flex-col">
                    <p class="block text-sm font-medium text-gray-300">JSON Data</p>
                    <p class="block text-sm text-gray-300">Send POST requests to <span class="px-1 bg-black rounded-md font-mono">/api/tmasigns</span></p>
                    <code id="jsondebug" class="mt-1 p-4 bg-black text-gray-300 whitespace-pre-wrap font-mono"></code>
                <div>
            </section>
        </div>
    </section>
</x-layout.app>