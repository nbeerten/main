<?php

namespace App\Http\Controllers;

use App\Classes\TMASigns\Config\Format;
use App\Classes\TMASigns\Config\Size;
use App\Classes\TMASigns\LocatorTool;
use App\Classes\TMASigns\TMASigns;
use App\Http\Requests\TMASignsJsonAPIRequest;
use Illuminate\Http\Request;

class TMASignsController extends Controller
{
    /**
     * Handles Json API requests
     *
     * @return void
     */
    public function json(TMASignsJsonAPIRequest $request)
    {
        $validated = $request->validated();

        $format = $validated['format'];
        $size = match ($validated['size']) {
            1 => Size::x1,
            2 => Size::x2,
            4 => Size::x4,
            6 => Size::x6
        };
        $options = $validated['options'];
        $text = $validated['text'];
        $subtext = $validated['subtext'];

        if ($format == 'tga' && $size != Size::x6) {
            return $this->tgaZip($size, $options, $text, $subtext);
        } elseif ($format == 'tga' && $size == Size::x6) {
            return $this->tgaRaw($size, $options, $text, $subtext);
        } elseif ($format == 'webp') {
            return $this->webp($size, $options, $text, $subtext);
        } else {
            return $this->jpg($size, $options, $text, $subtext);
        }
    }

    public function locatortool(Request $request)
    {
        $input = $request->input('urls', []);

        return (new LocatorTool($input))->get();
    }

    protected function jpg($size, $options, $text, $subtext)
    {
        $TMASigns = new TMASigns(Format::JPG, $size, $options, $text, $subtext);

        return response($TMASigns->get())->header('Content-Type', 'image/jpg');
    }

    protected function webp($size, $options, $text, $subtext)
    {
        $TMASigns = new TMASigns(Format::WEBP, $size, $options, $text, $subtext);

        return response($TMASigns->get())->header('Content-Type', 'image/webp');
    }

    protected function tgaZip($size, $options, $text, $subtext)
    {
        $TMASigns = new TMASigns(Format::TGA, $size, $options, $text, $subtext);
        $resource = $TMASigns->zipStream();
        $fstats = fstat($resource);

        return response(fread($resource, $fstats['size']))
               ->header('Content-Type', 'application/zip');
    }

    protected function tgaRaw($size, $options, $text, $subtext)
    {
        $TMASigns = new TMASigns(Format::TGA, $size, $options, $text, $subtext);

        return response($TMASigns->get())->header('Content-Type', 'image/tga');
    }
}
