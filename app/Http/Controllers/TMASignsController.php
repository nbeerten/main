<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Classes\TMASigns\TMASigns;

class TMASignsController extends Controller
{
    public function jpg($size, $text, $subtext) {
        $TMASigns = new TMASigns("jpg", $size, $text, $subtext);
        return response($TMASigns->jpg())
                ->header('Content-Type', 'image/jpg');
    }

    public function tga($size, $text, $subtext) {
        $TMASigns = new TMASigns("tga", $size, $text, $subtext);
        return response($TMASigns->tga());
    }

    public function json(Request $request) {
        $format = $request->input('format', '');
        $size = $request->input('size', 2);
        $text = $request->input('text', '');
        $subtext = $request->input('subtext', '');
        if($format == "jpg") return $this->jpg($size, $text, $subtext);
        if($format == "tga") return $this->tga($size, $text, $subtext);
    }
}
