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
     * @param  bool|null  $noindex
     * @param  mixed  ...$more
     * @return void
     */
    public static function make(
        string $title,
        string|null $description = null,
        string|null $thumbnail = null,
        bool $noindex = true,
        bool|null $noimageindex = true,
        mixed ...$more
    ): void {
        $seoable = new SEOable(
            title: $title,
            description: $description,
            thumbnail: $thumbnail,
            noindex: $noindex,
            noimageindex: $noimageindex
        );

        foreach ($more as $property => $value) {
            $seoable->{$property} = $value;
        }

        View::share('seo', $seoable);
    }
}
