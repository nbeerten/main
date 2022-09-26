<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Classes\TMASigns\TMASigns;

class TMASignsController extends Controller
{
    public function jpg($size, $text, $subtext = false) {
        $TMASigns = new TMASigns("jpg", $size, $text, $subtext);
        return response($TMASigns->jpg())
                ->header('Content-Type', 'image/jpg');
    }

    public function zip($size, $text, $subtext = false) {
        $TMASigns = new TMASigns("zip", $size, $text, $subtext);
        return response($TMASigns->zip());
    }

    public function json(Request $request) {
        $text = $request->input('text');
        $subtext = $request->input('subtext', false);
        $size = $request->input('size');
        $format = $request->input('format');

        if($format == "jpg") return $this->jpg($size, $text, $subtext);
        if($format == "zip") return $this->zip($size, $text, $subtext);
    }
}
