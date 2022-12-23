<?php

namespace App\Classes\SEO;

use Illuminate\Support\Facades\View;

/**
 * SEO tag generation class
 */
class SEO
{
    public static function make(
        string $title,
        ?string $description = null,
        ?string $thumbnail = null,
        bool $noindex = true,
        mixed ...$more
    ): void {
        $seoable = new SEOable(
            title: $title,
            description: $description,
            thumbnail: $thumbnail,
            noindex: $noindex
        );

        foreach ($more as $property => $value) {
            $seoable->{$property} = $value;
        }

        View::share('seo', $seoable);
    }
}
