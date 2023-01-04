<x-app.error-page :title="__('Forbidden')" code="403" :message="__($exception->getMessage() ?: 'Forbidden')" />
