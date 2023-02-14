<?php

namespace App\Classes\SEO;

use Blade;
use Spatie\Html\Facades\Html;

/**
 * Readonly class for retrieving data
 */
class SEOAble
{
    /**
     * Properties from class
     */
    private array $properties = [];

    /**
     * Construct a SEOAble object
     *
     * @param  null|array<Robots>  $noindex
     * @param  mixed  $schema
     * @return SEOAble
     */
    public function __construct(
        public readonly string $title,
        public readonly ?string $description = null,
        public readonly ?array $robots = null,
        public readonly mixed $schema = null,
        mixed ...$additional

    ) {
        foreach ($additional as $property => $value) {
            $this->properties[$property] = $value;
        }

        return $this;
    }

    public function __set(string $name, mixed $value): void
    {
        $this->properties[$name] = $value;
    }

    public function __get(string $name): mixed
    {
        return $this->properties[$name] ?? null;
    }

    /**
     * Render SEOAble to HTML string
     */
    public function toHtml(): string
    {
        $robots = '';
        foreach ($this->robots as $key => $rule) {
            $robots .= $rule;
            if ($key !== array_key_last($this->robots)) {
                $robots .= 'a';
            }
        }

        $og_image = 'https://next.nilsbeerten.nl/api/og';
        $og_image .= '?title='.rawurlencode($this->title);

        $properties = get_object_vars($this);

        $data = array_merge(
            $properties,
            [
                'robots' => $robots,
                'og_image' => $og_image,
            ]
        );

        return Blade::render(
            <<<'BLADE'
            <title>{{ $title ?? Request::path() }} - {{ config('app.name') }}</title>
            <meta name="robots" content="{{ $robots }}">
            <meta name="author" content="Nils Beerten">

            @if($seo->description && $seo->title)
                <meta name="description" content="{{ $description }}">

                <meta property="og:url" content="{{ Request::fullUrl() }}">
                <meta property="og:site_name" content="{{ Request::host() }}">
                <meta property="og:title" content="{{ $seo->title ?? Request::path() }} - {{ config('app.name') }}">
                <meta property="og:description" content="{{ $seo->description }}">

                <meta property="og:image" content="{{ $og_image }}">
                <meta property="og:image:type" content="image/png">
                <meta property="og:image:width" content="1200">
                <meta property="og:image:height" content="600">
                <meta property="og:image:alt" content="Decorative thumbnail with page title and logo of {{ config('app.name') }}.">

                <meta name="twitter:card" content="summary_large_image">
                <meta name="twitter:creator" content="@nbertn">
            @endif

            @if($schema)
                {!! $schema->toScript() !!}
            @endif
            BLADE,
            $data
        );
    }
}
