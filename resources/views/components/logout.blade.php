<form method="POST" action="{{ $action ?? route('logout') }}">
    @csrf

    <button type="submit" {{ $attributes }}>
        {{ $slot->isEmpty() ? __('Log out') : $slot }}
    </button>
</form>