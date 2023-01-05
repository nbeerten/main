<?php

namespace App\Http\Controllers;

use App\Classes\TMASigns\BigBatch;
use App\Classes\TMASigns\LocatorTool;
use App\Classes\TMASigns\TMASigns;
use App\Http\Requests\TMASignsJsonAPIRequest;
use Illuminate\Http\Request;

class TMASignsController extends Controller
{
    /**
     * Handles Json API requests
     *
     * @param  TMASignsJsonAPIRequest  $request
     * @return void
     */
    public function json(TMASignsJsonAPIRequest $request)
    {
        $validated = $request->validated();

        $format = $validated['format'];
        $size = $validated['size'];
        $options = $validated['options'];
        $text = $validated['text'];
        $subtext = $validated['subtext'];

        if ($format == 'tga' && $size != 6) {
            return $this->tgaZip($size, $options, $text, $subtext);
        }
        if ($format == 'tga' && $size = 6) {
            return $this->tgaRaw($size, $options, $text, $subtext);
        }
        if ($format == 'webp') {
            return $this->webp($size, $options, $text, $subtext);
        } else {
            return $this->jpg($size, $options, $text, $subtext);
        }
    }

    public function bigbatch(Request $request)
    {
        return (new BigBatch)->get();
    }

    public function locatortool(Request $request)
    {
        $input = $request->input('urls', []);

        return (new LocatorTool($input))->get();
    }

    protected function jpg($size, $options, $text, $subtext)
    {
        $TMASigns = new TMASigns('jpg', $size, $options, $text, $subtext);

        return response($TMASigns->get())->header('Content-Type', 'image/jpg');
    }

    protected function webp($size, $options, $text, $subtext)
    {
        $TMASigns = new TMASigns('webp', $size, $options, $text, $subtext);

        return response($TMASigns->get())->header('Content-Type', 'image/webp');
    }

    protected function tgaZip($size, $options, $text, $subtext)
    {
        $TMASigns = new TMASigns('tga', $size, $options, $text, $subtext);
        $resource = $TMASigns->zipStream();
        $fstats = fstat($resource);

        return response(fread($resource, $fstats['size']))
               ->header('Content-Type', 'application/zip');
    }

    protected function tgaRaw($size, $options, $text, $subtext)
    {
        $TMASigns = new TMASigns('tga', $size, $options, $text, $subtext);

        return response($TMASigns->get())->header('Content-Type', 'image/tga');
    }
}
