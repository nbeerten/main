<?php

namespace App\Classes\SEO;

/**
 * Readonly class for retrieving data
 */
class SEOable
{
    /**
     * Properties from class
     *
     * @var array
     */
    private array $properties = [];

    /**
     * Construct a SEOable object
     *
     * @param  string|null  $title
     * @param  string|null  $description
     * @param  string|null  $thumbnail
     * @param  bool  $noindex
     * @return SEOable
     */
    public function __construct(
        public readonly ?string $title,
        public readonly ?string $description,
        public readonly ?string $thumbnail,
        public readonly bool $noindex = true

    ) {
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

    public function array(): array
    {
        $array = [];
        foreach ($this as $key => $value) {
            $array[$key] = $value;
        }

        return $array;
    }
}
