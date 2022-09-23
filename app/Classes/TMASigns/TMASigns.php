<?php

namespace App\Classes\TMASigns;

use Exception;
use \Imagick as Imagick;
use \ImagickDraw as ImagickDraw;
use ZipStream;

class TMASigns
{
    private const fontsize = [
        2 => 150,
        4 => 200,
        6 => 100
    ];
    private const font = "../assets/TMASigns/Montserrat-Black.ttf";
    private const textcolor = '#f37520';
    private const base = [
        2 => '../assets/TMASigns/2x1.tga',
        4 => '../assets/TMASigns/4x1.tga',
        6 => '../assets/TMASigns/6x1.tga'
    ];
    private const margins = [
        2 => 800,
        4 => 1800,
        6 => 1300
    ];
    private const allowedfiletypes = ["jpg", "tga"];
    private const allowedsizes = [2, 4, 6];

    protected int $size;
    protected string $text;

    public function __construct(int $size, string $text)
    {
        $this->size = $size;
        $this->text = $text;
    }

    /**
     * Base function for creation of sign
     *
     * @param string $format Types in `allowedfiletypes` array
     * @param integer $size Sizes in `allowedsizes` array
     * @param string $text Text input to put on the sign
     * @return string Sign, idk which type it is
     */
    private function base(string $format)
    {
        if (!in_array($format, self::allowedfiletypes)) throw new Exception("Invalid format: $format");
        if (!in_array($this->size, self::allowedsizes)) throw new Exception("Invalid size: $this->size");

        $draw = new ImagickDraw();
        $draw->setFontSize(self::fontsize[$this->size]);
        $draw->setGravity(Imagick::GRAVITY_CENTER);
        $draw->setFont(self::font);
        $draw->setFillColor(self::textcolor);
        $draw->setTextAntialias(true);

        $canvas = new Imagick(self::base[$this->size]);
        $canvas->flipImage();

        $draw = $this->newfontsize($canvas, $draw);

        $canvas->annotateImage($draw, 0, 0, 0, $this->text);

        $format = in_array($format, self::allowedfiletypes) ? $format : "jpg";
        $canvas->setImageFormat($format);
        if ($format === "tga") $canvas->flipImage();

        $sign = $canvas->getImageBlob();

        return $sign;
    }

    /**
     * Calculate fontsize based on total width of image, to scale it down automatically so it won't cause overflow
     *
     * @param Imagick $canvas
     * @param ImagickDraw $draw
     * @return ImagickDraw Same object as the input parameter `$draw`
     */
    private function newfontsize(Imagick $canvas, ImagickDraw $draw)
    {
        $metrics = $canvas->queryFontMetrics($draw, $this->text, false);
        $CalculatedFontSize = floor($metrics["characterWidth"] * self::margins[$this->size] / $metrics["textWidth"]);
        $NewFontSize = $CalculatedFontSize < self::fontsize[$this->size] ? $CalculatedFontSize : self::fontsize[$this->size];
        $draw->setFontSize($NewFontSize);
        return $draw;
    }

    /**
     * Create ZipStream with a sign inside
     *
     * @param string $format
     * @return ZipStream
     */
    private function createzip(string $format = "tga")
    {
        $sign = $this->base($format);

        // enable output of HTTP headers
        $options = new ZipStream\Option\Archive();
        $options->setSendHttpHeaders(true);

        $zip = new ZipStream\ZipStream("tma_sign{$this->size}x1_{$this->text}.zip", $options);
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
    public function zip()
    {
        return $this->createzip("tga");
    }

    /**
     * Returns JPG output of 2x1 sized sign
     *
     * @param string $text
     * @return string JPG blob
     */
    public function jpg()
    {
        return $this->base("jpg");
    }

    /**
     * Dynamic file return
     *
     * @param string $text
     * @return string something
     */
    public function dynformat($format)
    {
        if($format == "jpg") return $this->jpg();
        if($format == "zip") return $this->zip();
        else return null;
    }
}
