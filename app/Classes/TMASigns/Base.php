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
    private Imagick $baseCanvas;
    private ImagickDraw $textStyling;
    private ImagickDraw $subTextStyling;

    /**
     * Image settings like compression, bitdepth and format.
     */
    private function ImageSettings() {
        $this->baseCanvas->setImageFormat($this->format);

        // Specific settings for TGA files
        if ($this->format === "tga") {
            $this->baseCanvas->flipImage(); // Fix for weird behaviour where TGA's are flipped on export. Don't ask why, but this works (:
            $this->baseCanvas->setImageCompression(Imagick::COMPRESSION_RLE); // Seemingly the most efficient compression for TGA
            $this->baseCanvas->setImageDepth(24); // Pixel depth of 24 bits. Meaning, only RGB supported. No alpha channel.
            $this->baseCanvas->setImageAlphaChannel(Imagick::ALPHACHANNEL_DEACTIVATE); // Somehow Trackmania still sees alpha channel, so this is neccesary.

            $this->baseCanvas->setImageCompressionQuality(100);
        };
        if ($this->format === "webp") {
            $this->baseCanvas->setImageCompression(Imagick::COMPRESSION_ZIP);
            $this->baseCanvas->setImageCompressionQuality(100);
        };
        if ($this->format === "jpg") {
            $this->baseCanvas->setImageCompression(Imagick::COMPRESSION_JPEG);
            $this->baseCanvas->setImageCompressionQuality(95);
        };
    }

    private function SingleLine()
    {
        $this->baseCanvas = $this->BaseCanvas();
        $this->textStyling = $this->Text();

        $this->baseCanvas->annotateImage($this->textStyling, 0, 0, 0, $this->text);

        // Set all image-specific settings
        $this->ImageSettings();

        $sign = $this->baseCanvas->getImageBlob();

        $this->baseCanvas->clear();
        $this->textStyling->clear();

        return $sign;
    }
    
    private function MultiLine()
    {
        $this->baseCanvas = $this->BaseCanvas();
        $this->textStyling = $this->Text();
        $this->subTextStyling = $this->SubText();

        $this->baseCanvas->annotateImage($this->subTextStyling, 0, Settings::offset[$this->options["subtextlocation"]][$this->size][1], 0, $this->subtext);
        $this->baseCanvas->annotateImage($this->textStyling, 0, Settings::offset[$this->options["subtextlocation"]][$this->size][0], 0, $this->text);

        // Set all image-specific settings
        $this->ImageSettings();

        $sign = $this->baseCanvas->getImageBlob();
        
        $this->baseCanvas->clear();
        $this->textStyling->clear();
        $this->subTextStyling->clear();

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

        $newStrokeWidth = ($this->size === 1 && strlen($this->text) <= 4) ? Settings::outlinewidth[$this->size] * 2 : Settings::outlinewidth[$this->size];
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
        else if(!empty($this->text) || $this->text === "0") return $this->SingleLine();
        else return abort(422);
    }
}