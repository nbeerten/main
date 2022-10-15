<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Validation\Rule;

use App\Classes\TMASigns\TMASigns;
use App\Classes\TMASigns\Settings;
use ZipStream;

class TMASignsController extends Controller
{
    public function jpg($size, $options, $text, $subtext) {
        $TMASigns = new TMASigns("jpg", $size, $options, $text, $subtext);
        return response($TMASigns->jpg())->header('Content-Type', 'image/jpg');
    }

    public function webp($size, $options, $text, $subtext) {
        $TMASigns = new TMASigns("webp", $size, $options, $text, $subtext);
        return response($TMASigns->webp())->header('Content-Type', 'image/webp');
    }

    public function tga_zip($size, $options, $text, $subtext) {
        $TMASigns = new TMASigns("tga", $size, $options, $text, $subtext);
        return response($TMASigns->tga_zip())->header('Content-Type', 'application/zip');
    }

    public function tga_raw($size, $options, $text, $subtext) {
        $TMASigns = new TMASigns("tga", $size, $options, $text, $subtext);
        return response($TMASigns->tga_raw())->header('Content-Type', 'image/tga');
    }

    public function json(Request $request)
    {
        $validated = $request->validate([
            'format' => ['required', 'string', Rule::in(Settings::allowedfiletypes)],
            'size' => ['required', 'numeric', Rule::in(Settings::allowedsizes)],
            'options' => ['sometimes', 'array'],
            'text' => ['bail', 'required', 'string', 'max:32'],
            'subtext' => ['sometimes', 'nullable', 'string', 'max:64']
        ]);

        $format = $validated['format'];
        $size = $validated['size'];
        $options = $validated['options'] ?? [];
        $text = $validated['text'];
        $subtext = $validated['subtext'] ?? null;

        
        if ($format == "tga" && $size != 6)
            return $this->tga_zip($size, $options, $text, $subtext);
        if ($format == "tga" && $size = 6)
            return $this->tga_raw($size, $options, $text, $subtext);
        if ($format == "webp")
            return $this->webp($size, $options, $text, $subtext);
        else
            return $this->jpg($size, $options, $text, $subtext);
    }

    public function batch(Request $request, $size)
    {

        // enable output of HTTP headers
        $options = new ZipStream\Option\Archive();
        $options->setSendHttpHeaders(true);

        $zip = new ZipStream\ZipStream("tma_sign{$size}x1_Checkpoint-1-25.zip", $options);

        for ($x = 1; $x <= 25; $x++) {
            $TMASigns = new TMASigns("tga", $size, [], "Checkpoint {$x}", '');

            $zip->addFile("Checkpoint_{$x}.tga", $TMASigns->tga_raw());
        }

        return $zip->finish();
    }

    public function locatortool(Request $request)
    {
        $input = $request->input('urls', []);

        // enable output of HTTP headers
        $options = new ZipStream\Option\Archive();
        $options->setSendHttpHeaders(true);

        $zip = new ZipStream\ZipStream("locators.zip", $options);
        
        $succesfulcount = 0;
        foreach ($input as $url) {
            if(!filter_var($url, FILTER_VALIDATE_URL)) break;
            $url = trim($url);
            $url = rtrim($url,"/");
            $regex = preg_match("/[^\/]*$/", $url, $filename);
            if(!$regex) break;
            $zip->addFile("{$filename[0]}.loc", $url);
            $succesfulcount++;
        }
        
        if($succesfulcount > 0) return $zip->finish();
        else return abort(400);
    }
}
