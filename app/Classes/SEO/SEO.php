<?php

namespace App\Classes\SEO;

use Illuminate\Support\Facades\View;

/**
 * SEO tag generation class
 */
class SEO
{
    /**
     * Generate global `$seo` variable
     *
     * @param  string  $title
     * @param  string|null  $description
     * @param  string|null  $thumbnail
     * @param  bool  $noindex
     * @param  mixed  ...$more
     * @return void
     */
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
