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
    protected $options;
    protected function colors($color, $default = "white") {
        if(!empty(Settings::colors[$color])) { return Settings::colors[$color]; }
        else return $default;
    }
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

        $this->baseCanvas->annotateImage($this->textStyling, 0, Settings::offset[$this->size][0], 0, $this->text);
        $this->baseCanvas->annotateImage($this->subTextStyling, 0, Settings::offset[$this->size][1], 0, $this->subtext);

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
        $draw->setFillColor($this->colors($this->options["color"], Settings::textcolor));
        $draw->setTextAntialias(true);

        $newStrokeWidth = ($this->size === 1 && strlen($this->text) <= 3) ? Settings::outlinewidth[$this->size] * 2 : Settings::outlinewidth[$this->size];
        $draw->setStrokeWidth($newStrokeWidth);
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
        
        $draw->setGravity(Imagick::GRAVITY_CENTER);
        $draw->setFont(Settings::font);
        $draw->setFillColor(Settings::subtextcolor);
        $draw->setTextAntialias(true);

        $metrics = $this->baseCanvas->queryFontMetrics($draw, $this->subtext, false);
        $calculatedFontSize = floor($metrics["characterWidth"] * Settings::margins[$this->size] / $metrics["textWidth"]);
        $newFontSize = $calculatedFontSize < Settings::subfontsize[$this->size] ? $calculatedFontSize : Settings::subfontsize[$this->size];
        $draw->setFontSize($newFontSize);
        
        return $draw;
    }

    public function get() {
        if(!empty($this->subtext) && $this->size != 6) return $this->MultiLine();
        else if(!empty($this->text)) return $this->SingleLine();
        else return abort(422);
    }
}