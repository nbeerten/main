<x-app.error-page :title="__('Not found')" code="404" :message="$exception->getMessage() ?? __('Page not found')" />