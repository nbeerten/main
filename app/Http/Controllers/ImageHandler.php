<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Classes\TMASigns\TMASigns;

class ImageHandler extends Controller
{
    public function jpg($size, $text) {
        $TMASigns = new TMASigns($size, $text);
        return response($TMASigns->jpg())
                ->header('Content-Type', 'image/jpg');
    }

    public function zip($size, $text) {
        $TMASigns = new TMASigns($size, $text);
        return response($TMASigns->zip());
    }

    public function json(Request $request) {
        $text = $request->input('text');
        $size = $request->input('size');
        $format = $request->input('format');

        if($format == "jpg") return $this->jpg($size, $text);
        if($format == "zip") return $this->zip($size, $text);
    }
}
