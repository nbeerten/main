<?php

namespace App\Classes\SEO;

use Illuminate\Support\Facades\View;

/**
 * SEO tag generation class
 */
class SEO
{
    /**
     * @param  Robots[]|null  $robots
     * @param  mixed  $schema
     */
    public static function share(
        ?string $key = 'seo',
        ?string $title = '',
        ?string $description = null,
        ?array $robots = [Robots::NOIMAGEINDEX],
        mixed $schema = null,
        mixed ...$additional
    ): SEOAble {
        $seoable = new SEOAble(
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
