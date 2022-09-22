<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Classes\TMASigns\TMASigns;

class ImageHandler extends Controller
{
    public function jpg(TMASigns $TMASigns, $size, $text) {
        return response($TMASigns->jpg($size, $text))
                ->header('Content-Type', 'image/jpg');
    }

    public function zip(TMASigns $TMASigns, $size, $text) {
        return response($TMASigns->zip($size, $text));
    }
}
