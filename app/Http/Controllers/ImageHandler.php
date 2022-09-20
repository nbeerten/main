<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Classes\TMASigns\Signs;

class ImageHandler extends Controller
{
    public function PreviewHandler(Signs $Signs, $size, $text) {
        if($size = "2x1") {
            return response($Signs->text2x1_jpg($text))
                    ->header('Content-Type', 'image/jpg');
        } else {
            return "a";
        }
    }

    public function ZipHandler(Signs $Signs, $size, $text) {
        if($size = "2x1") {
            return response($Signs->text2x1_zipped($text));
        } else {
            return "a";
        }
    }
}
