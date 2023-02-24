<?php

namespace App\Classes\TMASigns;

use App\Classes\TMASigns\Config\Format;
use App\Classes\TMASigns\Config\Size;
use Exception;
use ZipStream;

/**
 * Class for generating TMASigns
 */
class TMASigns extends Base
{
    public function __construct(Format $format, bool $shouldOutputZip, Size $size, array|null $options, string $text, string|null $subtext)
    {
        $this->format = $format;
        $this->shouldOutputZip = $shouldOutputZip;
        $this->size = $size;
        $this->options = $options;
        $this->text = $text;
        $this->subtext = $subtext;

        if (! empty($subtext) || $subtext === '0') {
            $this->isMultiline = 1;
        }
    }

    public function get(): ?string
    {
        if (empty($this->subtext) && empty($this->text) && $this->text !== '0') {
            throw new Exception('Neither text nor subtext provided.');
        }

        $outputImage = null;
        if ($this->isMultiline) {
            $outputImage = $this->create()->multiline()->toString();
        }
        if (! $this->isMultiline) {
            $outputImage = $this->create()->singleline()->toString();
        }

        $output = null;
        if ($this->shouldOutputZip) {
            $resource = $this->zipStream($outputImage, true);

            if ($fstat = fstat($resource)) {
                $size = $fstat['size'];
            } else {
                return throw new Exception('Unable to read zip from ZipStream resource.');
            }

            if ($fread = fread($resource, $size)) {
                $output = $fread;
            } else {
                return throw new Exception('Unable to read zip from ZipStream resource.');
            }
        } else {
            $output = $outputImage;
        }

        return $output;
    }

    public function getMimeType(): string
    {
        if ($this->shouldOutputZip) {
            $mimeType = 'application/zip';
        } else {
            $mimeType = match ($this->format) {
                Format::JPG => 'image/jpg',
                Format::TGA => 'image/tga',
                Format::WEBP => 'image/webp',
            };
        }

        return $mimeType;
    }

    /**
     * @return resource
     */
    public function zipStream(string $image, bool $skinjson = true): mixed
    {
        $tempStream = fopen('php://memory', 'r+');

        if ($tempStream === false) {
            throw new Exception('Creation of stream failed.');
        }

        $options = new ZipStream\Option\Archive();
        $options->setZeroHeader(true);
        $options->setOutputStream($tempStream);

        $filename = 'TMA2-text-';
        $filename .= "{$this->size->value}x1-";
        $filename .= strval(now()->unix());

        $zip = new ZipStream\ZipStream($filename, $options);
        $zip->addFile("sign.{$this->format->value}", $image);
        if ($skinjson) {
            $zip->addFile('Skin.json', <<<TXT
            {
                "ClassId": "Parallax",
                "Layers" =
                [
                    { Name="sign.{$this->format->value}", Depth="0" },
                ]
            }
            TXT);
        }

        $zip->finish();

        fflush($tempStream);
        rewind($tempStream);

        return $tempStream;
    }
}
