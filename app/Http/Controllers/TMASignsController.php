<?php

namespace App\Http\Controllers;

use App\Classes\TMASigns\Settings;
use App\Classes\TMASigns\TMASigns;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use ZipStream;

class TMASignsController extends Controller
{
    public function jpg($size, $options, $text, $subtext)
    {
        $TMASigns = new TMASigns('jpg', $size, $options, $text, $subtext);

        return response($TMASigns->get())->header('Content-Type', 'image/jpg');
    }

    public function webp($size, $options, $text, $subtext)
    {
        $TMASigns = new TMASigns('webp', $size, $options, $text, $subtext);

        return response($TMASigns->get())->header('Content-Type', 'image/webp');
    }

    public function tgaZip($size, $options, $text, $subtext)
    {
        $TMASigns = new TMASigns('tga', $size, $options, $text, $subtext);

        return response($TMASigns->getZip())->header('Content-Type', 'application/zip');
    }

    public function tgaRaw($size, $options, $text, $subtext)
    {
        $TMASigns = new TMASigns('tga', $size, $options, $text, $subtext);

        return response($TMASigns->get())->header('Content-Type', 'image/tga');
    }

    public function json(Request $request)
    {
        $validated = $request->validate([
            'format' => ['required', 'string', Rule::in(Settings::allowedfiletypes)],
            'size' => ['required', 'numeric', Rule::in(Settings::allowedsizes)],
            'options' => ['sometimes', 'array'],
            'text' => ['bail', 'required', 'string', 'max:32'],
            'subtext' => ['sometimes', 'nullable', 'string', 'max:64'],
        ]);

        $format = $validated['format'];
        $size = $validated['size'];
        $options = $validated['options'] ?? [];
        $text = $validated['text'];
        $subtext = $validated['subtext'] ?? null;

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
        $sizes = [2, 4, 6];

        // enable output of HTTP headers
        $options = new ZipStream\Option\Archive();
        $options->setSendHttpHeaders(true);

        $mainzip = new ZipStream\ZipStream('tma-bigbatch-text-and-cp-signs.zip', $options);

        foreach ($sizes as $size) {
            if ($size == 6) {
                for ($x = 1; $x <= 25; $x++) {
                    $x = str_pad($x, 2, '0', STR_PAD_LEFT);
                    $TMASigns = new TMASigns('jpg', $size, [], "Checkpoint {$x}", '');

                    $mainzip->addFile("Advertisement{$size}x1/tma-CP_{$size}x1/tma-CP-{$x}.jpg", $TMASigns->get());
                }
            }

            $strings = [
                'Start',
                'Finish',
                'Checkpoint',
                'GPS',
                'GPS back',
                'Multilap',
            ];

            if ($size !== 6) {
                foreach ($strings as $value) {
                    $TMASigns = new TMASigns('tga', $size, [], $value, '');
                    $value = str_replace(' ', '', strtolower($value));

                    $data = $TMASigns->tga_zip_stream();

                    $mainzip->addFileFromStream("Advertisement{$size}x1/tma-text_{$size}x1/tma-text-{$value}.zip", $data);
                    fclose($data);
                }
            } elseif ($size == 6) {
                foreach ($strings as $value) {
                    $TMASigns = new TMASigns('jpg', $size, [], $value, '');
                    $value = str_replace(' ', '', strtolower($value));

                    $mainzip->addFile("Advertisement{$size}x1/tma-text_{$size}x1/tma-text-{$value}.jpg", $TMASigns->get());
                }
            }
        }

        return $mainzip->finish();
    }

    public function locatortool(Request $request)
    {
        $input = $request->input('urls', []);

        // enable output of HTTP headers
        $options = new ZipStream\Option\Archive();
        $options->setSendHttpHeaders(true);

        $zip = new ZipStream\ZipStream('locators.zip', $options);

        $succesfulcount = 0;
        foreach ($input as $url) {
            if (! filter_var($url, FILTER_VALIDATE_URL)) {
                break;
            }
            $url = trim($url);
            $url = rtrim($url, '/');
            $regex = preg_match("/[^\/]*$/", $url, $filename);
            if (! $regex) {
                break;
            }
            $zip->addFile("{$filename[0]}.loc", $url);
            $succesfulcount++;
        }

        if ($succesfulcount > 0) {
            return $zip->finish();
        } else {
            return abort(400);
        }
    }
}
