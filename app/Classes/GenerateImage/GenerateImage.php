<?php

namespace App\Classes\GenerateImage;

use \Imagick as Imagick;
use \ImagickDraw as ImagickDraw;
use ZipStream;

class GenerateImage {

    protected $template;

    function __construct($template = null) 
    {
        $this->template = $template;
    }

    public function testDDS(string $text) {
        $draw = new ImagickDraw();
        $draw->setFontSize(120);
        $draw->setGravity(Imagick::GRAVITY_CENTER);
        $draw->setFillColor('white');
        $draw->setFont("../public/assets/GenerateImage/Montserrat-Bold.ttf");
        $canvas = new Imagick();
        $canvas->newImage(1536, 256, "#1e2326");
        $canvas->annotateImage($draw, 0, 0, 0, $text);
        $canvas->setCompression(Imagick::COMPRESSION_DXT5);
        // $canvas->setOption("dds:mipmaps", 1);
        $canvas->setImageFormat('dds');
        $maindds = $canvas->getImageBlob();
        $canvas->destroy();
        
        $time = time();

        // enable output of HTTP headers
        $options = new ZipStream\Option\Archive();
        $options->setSendHttpHeaders(true);

        $zip = new ZipStream\ZipStream("sign_{$text}_{$time}.zip", $options);
        $zip->addFile('main.dds', $maindds);
        
        return $zip->finish();
    }

    public function testTGA(string $text) {
        $draw = new ImagickDraw();
        $draw->setFontSize(120);
        $draw->setGravity(Imagick::GRAVITY_CENTER);
        $draw->setFillColor('white');
        $draw->setFont("../public/assets/GenerateImage/Montserrat-Bold.ttf");
        $canvas = new Imagick();
        $canvas->newImage(1536, 256, "#1e2326");
        $canvas->annotateImage($draw, 0, 0, 0, $text);
        $canvas->setImageFormat('tga');
        $canvas->flipImage();
        $maintga = $canvas->getImageBlob();
        
        return $maintga;
    }
}