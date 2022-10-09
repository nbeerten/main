<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Classes\TMASigns\TMASigns;

class TMASignsController extends Controller
{
    public function jpg($size, $options, $text, $subtext) {
        $TMASigns = new TMASigns("jpg", $size, $options, $text, $subtext);
        return response($TMASigns->jpg())
                ->header('Content-Type', 'image/jpg');
    }

    public function tga($size, $options, $text, $subtext) {
        $TMASigns = new TMASigns("tga", $size, $options, $text, $subtext);
        return response($TMASigns->tga());
    }

    public function json(Request $request) {
        $format = $request->input('format', '');
        $size = $request->input('size', 2);
        $options = $request->input('options');
        $text = $request->input('text', '');
        $subtext = $request->input('subtext', '');
        if($format == "jpg") return $this->jpg($size, $options, $text, $subtext);
        if($format == "tga") return $this->tga($size, $options, $text, $subtext);
    }
}
