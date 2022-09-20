<?php

namespace App\Classes\TMASigns;

use \Imagick as Imagick;
use \ImagickDraw as ImagickDraw;
use ZipStream;

class Signs {

    private const FONTSIZE = 150;
    private const FONT = "../storage/app/TMASigns/Montserrat-Black.ttf";
    private const BASE2X1 = '../storage/app/TMASigns/2x1.tga';

    /**
     * Base function for 2x1 sized signs. Returns a close to ready $canvas object
     *
     * @param string $text
     * @return Imagick $canvas
     */
    private function text2x1(string $text) {
        $draw = new ImagickDraw();
        $draw->setFontSize($this::FONTSIZE);
        $draw->setGravity(Imagick::GRAVITY_CENTER);
        $draw->setFont($this::FONT);
        $draw->setFillColor('#f37520');
        $draw->setTextAntialias(true);
        $canvas = new Imagick($this::BASE2X1);
        $canvas->flipImage();

        $metrics = $canvas->queryFontMetrics($draw, $text, false);
        $CalculatedFontSize = floor($metrics["characterWidth"] * 800 / $metrics["textWidth"]);
        $NewFontSize = $CalculatedFontSize < $this::FONTSIZE ? $CalculatedFontSize : $this::FONTSIZE;
        $draw->setFontSize($NewFontSize);
        
        $canvas->annotateImage($draw, 0, 0, 0, $text);
        
        return $canvas;
    }

    /**
     * Returns Zip output of 2x1 sized sign. Packaged in zip for further file compression
     *
     * @param string $text
     * @return string Zip file
     */
    public function text2x1_zipped(string $text) {
        $canvas = $this->text2x1($text);

        $canvas->setImageFormat("tga");
        $canvas->flipImage();
        $signtga = $canvas->getImageBlob();

        // enable output of HTTP headers
        $options = new ZipStream\Option\Archive();
        $options->setSendHttpHeaders(true);

        $zip = new ZipStream\ZipStream("tma_sign2x1_$text.zip", $options);
        $zip->addFile('sign.tga', $signtga);
        
        return $zip->finish();
    }

    /**
     * Returns JPG output of 2x1 sized sign
     *
     * @param string $text
     * @return string JPG blob
     */
    public function text2x1_jpg(string $text) {
        $canvas = $this->text2x1($text);

        $canvas->setImageFormat("jpg");
        $sign = $canvas->getImageBlob();
        
        return $sign;
    }
}