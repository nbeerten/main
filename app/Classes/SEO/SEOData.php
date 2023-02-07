<?php

namespace App\Classes\SEO;

use Illuminate\Support\Facades\View;

/**
 * SEO tag generation class
 */
class SEOData
{
    /**
     * Undocumented function
     *
     * @param  string      $title
     * @param  string|null $description
     * @param  null|array<Robots>  $robots
     * @param  mixed $schema
     * @param  mixed|null  ...$additional
     * @return SEODataAble
     */
    public function __construct(
        ?string $key = 'seo',
        ?string $title = '',
        ?string $description = null,
        ?array $robots = [Robots::NOIMAGEINDEX],
        mixed $schema = null,
        mixed ...$additional
    )
    {
        $seoable = new SEODataAble(
            title: $title,
            description: $description,
            robots: $robots,
            schema: $schema,
            additional: $additional
        );

        View::share($key, $seoable);

        return $seoable;
    }
}
