<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Classes\TMASigns\TMASigns;
use ZipStream;

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
        $options = $request->input('options', []);
        $text = $request->input('text', '');
        $subtext = $request->input('subtext', '');
        if($format == "jpg") return $this->jpg($size, $options, $text, $subtext);
        if($format == "tga") return $this->tga($size, $options, $text, $subtext);
    }

    public function batch(Request $request, $size) {

        // enable output of HTTP headers
        $options = new ZipStream\Option\Archive();
        $options->setSendHttpHeaders(true);

        $zip = new ZipStream\ZipStream("tma_sign{$size}x1_Checkpoint-1-25.zip", $options);
        
        for ($x = 1; $x <= 25; $x++) {
            $TMASigns = new TMASigns("tga", $size, [], "Checkpoint {$x}", '');
            
            $zip->addFile("Checkpoint_{$x}.tga", $TMASigns->tgaraw());
        }

        return $zip->finish();
    }
}
