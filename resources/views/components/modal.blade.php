<dialog class="modal" x-ref="modal" data-id="{{ $dataId }}" 
    x-data="{ open: false, toggle() { this.open = !this.open; !this.open ? $refs.modal.close() : $refs.modal.showModal(); } }"
    x-on:open-{{ $dataId }}.window="toggle()"
    x-on:keydown.escape.window="toggle()">
    <div x-show="open" x-on:click.outside="toggle()">
        <h4>{{ $title ?? 'Modal Title' }}</h4>
        <section class="content">
            {{ $slot }}
        </section>
        <button x-on:click="toggle()" class="button">Close</button>
    <div>
</dialog>
