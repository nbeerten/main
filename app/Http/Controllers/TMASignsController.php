<?php

namespace App\Http\Controllers;

use App\Classes\TMASigns\Config\Format;
use App\Classes\TMASigns\Config\Size;
use App\Classes\TMASigns\LocatorTool;
use App\Classes\TMASigns\TMASigns;
use App\Http\Requests\TMASignsJsonAPIRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TMASignsController extends Controller
{
    protected Format $format;

    protected bool $shouldOutputZip = false;

    protected Size $size;

    protected ?array $options;

    protected ?string $text;

    protected ?string $subtext;

    /**
     * Handles Json API requests
     */
    public function json(TMASignsJsonAPIRequest $request): Response
    {
        $validated = $request->validated();

        $this->format = match ($validated['format']) {
            'jpg' => Format::JPG,
            'tga' => Format::TGA,
            'webp' => Format::WEBP,
            default => Format::JPG
        };
        $this->shouldOutputZip = $validated['shouldOutputZip'];
        $this->size = match ($validated['size']) {
            1 => Size::x1,
            2 => Size::x2,
            4 => Size::x4,
            6 => Size::x6,
            default => Size::x2
        };
        $this->options = $validated['options'];
        $this->text = $validated['text'];
        $this->subtext = $validated['subtext'];

        $TMASigns = new TMASigns(
            $this->format,
            $this->shouldOutputZip,
            $this->size,
            $this->options,
            $this->text,
            $this->subtext
        );

        return response($TMASigns->get())
            ->header('Content-Type', $TMASigns->getMimeType());
    }

    public function locatortool(Request $request): Response
    {
        $input = $request->input('urls', []);

        return response((new LocatorTool($input))->get());
    }
}
