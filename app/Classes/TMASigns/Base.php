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
    protected $text;
    protected $subtext;

    private Imagick $baseCanvas;
    private ImagickDraw $textStyling;
    private ImagickDraw $subTextStyling;

    private function SingleLine()
    {
        $this->baseCanvas = $this->BaseCanvas();
        $this->textStyling = $this->Text();

        $this->baseCanvas->annotateImage($this->textStyling, 0, 0, 0, $this->text);

        $this->baseCanvas->setImageFormat($this->format);
        if ($this->format === "tga") $this->baseCanvas->flipImage();

        $sign = $this->baseCanvas->getImageBlob();

        return $sign;
    }
    
    private function MultiLine()
    {
        $this->baseCanvas = $this->BaseCanvas();
        $this->textStyling = $this->Text();
        $this->subTextStyling = $this->SubText();

        $this->baseCanvas->annotateImage($this->textStyling, 0, -40, 0, $this->text);
        $this->baseCanvas->annotateImage($this->subTextStyling, 0, 125, 0, $this->subtext);

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

    private function Text() {
        $draw = new ImagickDraw();
        
        $draw->setGravity(Imagick::GRAVITY_CENTER);
        $draw->setFont(Settings::font);
        $draw->setFillColor(Settings::textcolor);
        $draw->setTextAntialias(true);

        $draw->setStrokeWidth(Settings::outlinewidth[$this->size]);
        $draw->setStrokeColor(Settings::outlinecolor);
        $draw->setStrokeAntialias(true);

        $metrics = $this->baseCanvas->queryFontMetrics($draw, $this->text, false);
        $calculatedFontSize = floor($metrics["characterWidth"] * Settings::margins[$this->size] / $metrics["textWidth"]);
        $newFontSize = $calculatedFontSize < Settings::fontsize[$this->size] ? $calculatedFontSize : Settings::fontsize[$this->size];
        $draw->setFontSize($newFontSize);
        
        return $draw;
    }
    private function SubText() {
        $draw = new ImagickDraw();

        $metrics = $this->baseCanvas->queryFontMetrics($draw, $this->text, false);
        $calculatedFontSize = floor($metrics["characterWidth"] * Settings::margins[$this->size] / $metrics["textWidth"]);
        $newFontSize = $calculatedFontSize < Settings::subfontsize[$this->size] ? $calculatedFontSize : Settings::subfontsize[$this->size];
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
        if(!empty($this->subtext) && $this->size != 6) return $this->MultiLine();
        else if(!empty($this->text)) return $this->SingleLine();
        else return abort(422);
    }
}