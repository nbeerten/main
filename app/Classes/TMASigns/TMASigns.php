<?php

namespace App\Classes\TMASigns;

use ZipStream;
use Exception;

use App\Classes\TMASigns\Settings;

class TMASigns extends Base
{
    public function __construct(string $format, int $size, array $options, $text, $subtext)
    {
        if (!in_array($format, Settings::allowedfiletypes)) throw new Exception("Invalid format: $format");
        if (!in_array($size, Settings::allowedsizes)) throw new Exception("Invalid size: $size");

        $this->format = $format;
        $this->size = $size;
        $this->options = array_merge(Settings::options, $options);
        $this->text = $text;
        $this->subtext = $subtext;
    }

    /**
     * Create ZipStream with a sign inside
     *
     * @param string $format
     * @return ZipStream
     */
    private function createzip(string $format = "tga")
    {
        $sign = Base::get();

        // enable output of HTTP headers
        $options = new ZipStream\Option\Archive();
        $options->setSendHttpHeaders(true);

        $zip = new ZipStream\ZipStream("tma_sign{$this->size}x1_{$this->text}.zip", $options);
        $zip->addFile("sign.$format", $sign);
        $zip->addFileFromPath("Skin.json", Settings::skinjsonpath);

        return $zip->finish();
    }

    /**
     * Returns zip file of .tga file
     *
     * @return string ZIP file blob
     */
    public function tga()
    {
        return $this->createzip("tga");
    }

    /**
     * Returns zip file of .tga file
     *
     * @return string ZIP file blob
     */
    public function tgaraw()
    {
        return Base::get();
    }

    /**
     * Returns JPG output of 2x1 sized sign
     *
     * @return string JPG blob
     */
    public function jpg()
    {
        return Base::get();
    }
}
