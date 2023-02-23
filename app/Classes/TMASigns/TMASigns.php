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
    /**
     * @param  array<array<string|int>|string|int>|null  $options
     */
    public function __construct(Format $format, Size $size, array|null $options, string $text, string|null $subtext)
    {
        $this->format = $format;
        $this->size = $size;
        $this->options = $options;
        $this->text = $text;
        $this->subtext = $subtext;

        if (! empty($subtext) || $subtext === '0') {
            $this->multiline = 1;
        }
    }

    public function get(): string
    {
        if (! empty($this->subtext)) {
            return $this->create()->multiline()->toString();
        } elseif (! empty($this->text) || $this->text === '0') {
            return $this->create()->singleline()->toString();
        } else {
            throw new Exception('Neither text nor subtext provided.');
        }
    }

    /**
     * Create stream for the sign
     *
     * @param  bool  $skinjson Whether or not a Skin.json should be included
     * @return resource Stream with .zip
     */
    public function zipStream(bool $skinjson = true): mixed
    {
        $sign = $this->get();

        $tempStream = fopen('php://memory', 'r+');

        $options = new ZipStream\Option\Archive();
        $options->setZeroHeader(true);
        $options->setOutputStream($tempStream);

        $filename = 'TMA2-text-';
        $filename .= "{$this->size->value}x1-";
        $filename .= strval(now()->unix());

        $zip = new ZipStream\ZipStream($filename, $options);
        $zip->addFile("sign.{$this->format->value}", $sign);
        if ($skinjson) {
            $zip->addFileFromPath('Skin.json', Settings::SKINJSONPATH);
        }

        $zip->finish();

        fflush($tempStream);
        rewind($tempStream);

        if ($tempStream === false) {
            throw new Exception('Creation of zip failed.');
        }

        return $tempStream;
    }
}
