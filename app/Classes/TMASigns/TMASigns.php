<?php

namespace App\Classes\TMASigns;

use Exception;
use \Imagick as Imagick;
use \ImagickDraw as ImagickDraw;
use ZipStream;

class TMASigns {
    private const fontsize = [
        2 => 150
    ];
    private const font = "../storage/app/TMASigns/Montserrat-Black.ttf";
    private const textcolor = '#f37520';
    private const base = [
        2 => '../storage/app/TMASigns/2x1.tga'
    ];
    private const margins = [
        2 => 800
    ];
    private const allowedfiletypes = ["jpg", "tga"];
    private const allowedsizes = [1, 2, 4, 6];

    /**
     * Base function for creation of sign
     *
     * @param string $format Types in `allowedfiletypes` array
     * @param integer $size Sizes in `allowedsizes` array
     * @param string $text Text input to put on the sign
     * @return string Sign, idk which type it is
     */
    private function base(string $format, int $size, string $text) {
        if(!in_array($format, self::allowedfiletypes)) throw new Exception("Invalid format: $format");
        if(!in_array($size, self::allowedsizes)) throw new Exception("Invalid size: $size");
        $draw = new ImagickDraw();
        $draw->setFontSize(self::fontsize[$size]);
        $draw->setGravity(Imagick::GRAVITY_CENTER);
        $draw->setFont(self::font);
        $draw->setFillColor(self::textcolor);
        $draw->setTextAntialias(true);
        $canvas = new Imagick(self::base[$size]);
        $canvas->flipImage();

        $metrics = $canvas->queryFontMetrics($draw, $text, false);
        $CalculatedFontSize = floor($metrics["characterWidth"] * self::margins[2] / $metrics["textWidth"]);
        $NewFontSize = $CalculatedFontSize < self::fontsize[2] ? $CalculatedFontSize : self::fontsize[2];
        $draw->setFontSize($NewFontSize);
        
        $canvas->annotateImage($draw, 0, 0, 0, $text);

        $format = in_array($format, self::allowedfiletypes) ? $format : "jpg";
        $canvas->setImageFormat($format);
        if($format === "tga") $canvas->flipImage();
        
        $sign = $canvas->getImageBlob();
        
        return $sign;
    }

    private function createzip(string $format = "tga", int $size, string $text) {
        $sign = $this->base($format, $size, $text);

        // enable output of HTTP headers
        $options = new ZipStream\Option\Archive();
        $options->setSendHttpHeaders(true);

        $zip = new ZipStream\ZipStream("tma_sign{$size}x1_{$text}.zip", $options);
        $zip->addFile("sign.$format", $sign);
        
        return $zip->finish();
    }

    /**
     * Returns zip file of .tga file
     *
     * @param integer $size
     * @param string $text
     * @return string ZIP file blob
     */
    public function zip(int $size, string $text) {
        return $this->createzip("tga", $size, $text);
    }

    /**
     * Returns JPG output of 2x1 sized sign
     *
     * @param string $text
     * @return string JPG blob
     */
    public function jpg(int $size, string $text) {
        return $this->base("jpg", $size, $text);
    }
}