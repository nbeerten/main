<?php

namespace App\Classes\SEO;

use Illuminate\Support\Facades\View;

use App\Classes\SEO\SEOable;

/**
 * SEO tag generation class
 */
class SEO
{
    static function make(
        string $title,
        ?string $description = null,
        ?string $thumbnail = null,
        bool $noindex = true,
        mixed ...$more
    ) : void {
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