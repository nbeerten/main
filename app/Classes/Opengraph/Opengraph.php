<?php

namespace App\Classes\Opengraph;

use Exception;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Blade;

use App\Classes\Opengraph\Opengraphable;

/**
 * Opengraph thumbnail generation for embedding in social media
 */
class Opengraph
{
    static function make(
        false|string $title = false,
        false|string $description = false,
        false|string $thumbnail = false,
        ?bool $noindex = true
    ) : void {
        View::share('opengraph', 
            new Opengraphable(
                title: $title,
                description: $description,
                thumbnail: $thumbnail,
                noindex: $noindex
            )
        );
    }
}