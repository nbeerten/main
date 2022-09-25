<?php

namespace App\Classes\TMASigns;

use \Imagick as Imagick;
use \ImagickDraw as ImagickDraw;

use App\Classes\TMASigns\Settings;

/**
 * Base methods for TMASigns
 */
class Base
{
    protected string $format;
    protected int $size;
    protected string $text;

    private Imagick $baseCanvas;
    private ImagickDraw $textStyling;

    private function SingleLine()
    {
        $this->baseCanvas = $this->BaseCanvas();
        $this->textStyling = $this->SingleLineText();

        $this->baseCanvas->annotateImage($this->textStyling, 0, 0, 0, $this->text);

        $this->baseCanvas->setImageFormat($this->format);
        if ($this->format === "tga") $this->baseCanvas->flipImage();

        $sign = $this->baseCanvas->getImageBlob();

        return $sign;
    }

    private function BaseCanvas() {
        $canvas = new Imagick(Settings::base[$this->size]);
        $canvas->flipImage();
        return $canvas;
    }

    private function SingleLineText() {
        $draw = new ImagickDraw();

        $metrics = $this->baseCanvas->queryFontMetrics($draw, $this->text, false);
        $calculatedFontSize = floor($metrics["characterWidth"] * Settings::margins[$this->size] / $metrics["textWidth"]);
        $newFontSize = $calculatedFontSize < Settings::fontsize[$this->size] ? $calculatedFontSize : Settings::fontsize[$this->size];
        $draw->setFontSize($newFontSize);
        
        $draw->setGravity(Imagick::GRAVITY_CENTER);
        $draw->setFont(Settings::font);
        $draw->setFillColor(Settings::textcolor);
        $draw->setTextAntialias(true);

        $draw->setStrokeWidth(Settings::outlinewidth[$this->size]);
        $draw->setStrokeColor(Settings::outlinecolor);
        $draw->setStrokeAntialias(true);
        
        return $draw;
    }

    public function get() {
        return $this->SingleLine();
    }
}