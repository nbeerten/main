<?php

namespace App\Classes\TMASigns;

use Exception;
use ZipStream;

/**
 * Class for generating TMASigns
 */
class TMASigns extends Base
{
    public function __construct(
        protected string $format,
        protected int $size,
        protected $options,
        protected $text,
        protected $subtext
    ) {
        $settings = new Settings;
        if (! in_array($format, $settings->allowedfiletypes)) {
            throw new Exception("Invalid format: $format");
        }
        if (! in_array($size, $settings->allowedsizes)) {
            throw new Exception("Invalid size: $size");
        }

        if (! empty($subtext) || $subtext === '0') {
            $this->multiline = 1;
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
        $settings = new Settings();
        $sign = Base::get();

        $tempStream = fopen('php://memory', 'r+');

        $options = new ZipStream\Option\Archive();
        $options->setZeroHeader(true);
        $options->setOutputStream($tempStream);

        $filename = 'TMA2-text-';
        $filename .= "{$this->size}x1-";
        $filename .= strval(now()->unix());

        $zip = new ZipStream\ZipStream($filename, $options);
        $zip->addFile("sign.$this->format", $sign);
        if ($skinjson) {
            $zip->addFileFromPath('Skin.json', $settings->skinjsonpath);
        }

        $zip->finish();

        fflush($tempStream);
        rewind($tempStream);

        if ($tempStream === false) {
            throw new Exception('Creation of zip failed.');
        }

        return $tempStream;
    }

    /**
     * Returns the content in specified format
     *
     * @return mixed
     */
    public function get(): mixed
    {
        return Base::get();
    }
}
