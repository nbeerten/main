<div class="flex flex-col lg:flex-row gap-4 no-scrollbar">
    <section class="lg:w-1/2 flex flex-col lg:block gap-2">
        <input wire:model.debounce.500ms="text" type="text" placeholder="Text" class="text-black">
        <input wire:model.debounce.500ms="subtext" type="text" placeholder="Subtext" class="text-black">
        <select wire:model.debounce.10ms="size" name="Size" id="size" class="text-black">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="4">4</option>
            <option value="6">6</option>
        </select>
    </section>
    <section class="lg:w-1/2"><img src="{{ $preview }}"></section>
</div>