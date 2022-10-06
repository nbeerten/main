<x-errorpage :title="__('Forbidden')" code="403" :message="__($exception->getMessage() ?: 'Forbidden')" />
