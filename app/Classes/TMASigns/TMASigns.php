<?php

namespace App\Classes\TMASigns;

use Exception;
use ZipStream;

class TMASigns extends Base
{
    public function __construct(
        protected string $format,
        protected int $size,
        protected $options,
        protected $text,
        protected $subtext
    ) {
        if (! in_array($format, Settings::allowedfiletypes)) {
            throw new Exception("Invalid format: $format");
        }
        if (! in_array($size, Settings::allowedsizes)) {
            throw new Exception("Invalid size: $size");
        }
    }

    /**
     * Create ZipStream with a sign inside
     *
     * @param  string  $format
     * @return mixed
     */
    private function createzip(string $format = 'tga'): mixed
    {
        $sign = Base::get();

        $fn_text = str_replace(' ', '', strtolower($this->text));
        $fn_subtext = ! empty($this->subtext) ? str_replace(' ', '', strtolower($this->subtext)).'_' : '';
        $filename = "tma-text-{$fn_text}-{$fn_subtext}{$this->size}x1-UG";

        $zip = new ZipStream\ZipStream($filename);
        $zip->addFile("sign.$format", $sign);
        $zip->addFileFromPath('Skin.json', Settings::skinjsonpath);

        return $zip->finish();
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

    /**
     * Returns zip file of .tga file
     *
     * @return mixed ZIP file
     */
    public function getZip(): mixed
    {
        return $this->createzip('tga');
    }

    /**
     * Returns zip file of .tga file
     *
     * @return resource Stream of `.zip` version of request resource
     */
    public function getZipAsStream(): resource
    {
        $tempStream = fopen('php://memory', 'r+');
        $sign = Base::get();

        // enable output of HTTP headers
        $options = new ZipStream\Option\Archive();
        $options->setZeroHeader(true);
        $options->setOutputStream($tempStream);

        $filename = 'tma_sign';
        $filename .= "{$this->size}x1";
        $filename .= "_{$this->text}";
        $filename .= (! empty($this->subtext) ? "_{$this->subtext}" : '');

        $zip = new ZipStream\ZipStream($filename, $options);
        $zip->addFile('sign.tga', $sign);
        $zip->addFileFromPath('Skin.json', Settings::skinjsonpath);

        $zip->finish();

        fflush($tempStream);
        rewind($tempStream);

        if ($tempStream === false) {
            throw new Exception('TMASigns::getZipAsStream() failed.');
        }

        return $tempStream;
    }

    /**
     * Returns zip file of .tga file
     *
     * @return string ZIP file blob
     *
     * @deprecated 21-12-22
     */
    public function tga_zip()
    {
        return $this->createzip('tga');
    }

    /**
     * Returns zip file of .tga file
     *
     * @return string Raw TGA file blob
     *
     * @deprecated 21-12-22
     */
    public function tga_raw()
    {
        return Base::get();
    }

    /**
     * Returns JPG output of 2x1 sized sign
     *
     * @return string JPG blob
     *
     * @deprecated 21-12-22
     */
    public function jpg()
    {
        return Base::get();
    }

    /**
     * Returns WEBP output of 2x1 sized sign
     *
     * @return string WEBP blob
     *
     * @deprecated 21-12-22
     */
    public function webp()
    {
        return Base::get();
    }
}
