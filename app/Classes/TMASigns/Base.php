<?php

namespace App\Classes\TMASigns;

use Imagick;
use ImagickDraw;
use ImagickPixel;

/**
 * Base methods for TMASigns
 */
class Base
{
    /**
     *  Easy-access variable to check if sign is multiline
     */
    protected int $multiline = 0;

    protected string $format;

    protected int $size;

    protected $options;

    protected $text;

    protected $subtext;

    private Imagick $baseCanvas;

    private ImagickDraw $textStyling;

    private ImagickDraw $subTextStyling;

    /**
     * Image settings like compression, bitdepth and format.
     *
     * @return void
     */
    private function imageSettings(): void
    {
        $this->baseCanvas->setImageFormat($this->format);

        // Specific settings for TGA files
        if ($this->format === 'tga') {
            $this->baseCanvas->flipImage(); // Fix for weird behaviour where TGA's are flipped on export. Don't ask why, but this works (:
            $this->baseCanvas->setImageCompression(Imagick::COMPRESSION_RLE); // Seemingly the most efficient compression for TGA
            $this->baseCanvas->setImageDepth(24); // Pixel depth of 24 bits. Meaning, only RGB supported. No alpha channel.
            $this->baseCanvas->setImageAlphaChannel(Imagick::ALPHACHANNEL_DEACTIVATE); // Somehow Trackmania still sees alpha channel, so this is neccesary.

            $this->baseCanvas->setImageCompressionQuality(100);
        }
        if ($this->format === 'webp') {
            $this->baseCanvas->setImageCompression(Imagick::COMPRESSION_ZIP);
            $this->baseCanvas->setImageCompressionQuality(100);
        }
        if ($this->format === 'jpg') {
            $this->baseCanvas->setImageCompression(Imagick::COMPRESSION_JPEG);
            $this->baseCanvas->setImageCompressionQuality(95);
        }
    }

    /**
     * Create singe-line style sign
     *
     * @return string Blob of single-line sign
     */
    private function singleLine(): string
    {
        $this->baseCanvas = $this->baseCanvas();
        $this->textStyling = $this->text();

        $this->baseCanvas->annotateImage(
            $this->textStyling,
            0,
            0 + ($this->options['offsetText'] ?? 0),
            0,
            $this->text);

        // Set all image-specific settings
        $this->imageSettings();

        $sign = $this->baseCanvas->getImageBlob();

        $this->baseCanvas->clear();
        $this->textStyling->clear();

        return $sign;
    }

    /**
     * Create multi-line style sign
     *
     * @return string Blob of multi-line sign
     */
    private function multiLine(): string
    {
        $settings = new Settings;
        $this->baseCanvas = $this->baseCanvas();
        $this->textStyling = $this->text();
        $this->subTextStyling = $this->subText();

        $this->baseCanvas->annotateImage(
            $this->subTextStyling,
            0,
            $settings->offset[$this->options['subtextlocation']][$this->size][1] + ($this->options['offsetSubtext'] ?? 0),
            0,
            $this->subtext);
        $this->baseCanvas->annotateImage(
            $this->textStyling,
            0,
            $settings->offset[$this->options['subtextlocation']][$this->size][0] + ($this->options['offsetText'] ?? 0),
            0,
            $this->text);

        // Set all image-specific settings
        $this->imageSettings();

        $sign = $this->baseCanvas->getImageBlob();

        $this->baseCanvas->clear();
        $this->textStyling->clear();
        $this->subTextStyling->clear();

        return $sign;
    }

    /**
     * Create base canvas. Sets the size of the canvas, and does a fixed for Imagick's reading of `.tga` files.
     *
     * @return Imagick
     */
    private function baseCanvas(): Imagick
    {
        $settings = new Settings;
        $canvas = new Imagick($settings->base[$this->size]);
        $canvas->flipImage();

        return $canvas;
    }

    /**
     * Sets ImagickDraw styling for big text
     *
     * @return ImagickDraw Styling
     */
    private function text(): ImagickDraw
    {
        $settings = new Settings;
        $draw = new ImagickDraw();

        $draw->setGravity(Imagick::GRAVITY_CENTER);
        $draw->setFont($settings->font);
        $draw->setFillColor(new ImagickPixel($settings->textcolor));
        $draw->setTextAntialias(true);

        $strokeWidth = ($this->size === 1 && strlen($this->text) <= 4) ? $settings->outlinewidth[$this->size][$this->multiline] * 2 : $settings->outlinewidth[$this->size][$this->multiline];
        $newStrokeWidth = round($strokeWidth + ($this->options['outlineModifier'] ?? 0), 3);
        $draw->setStrokeWidth($newStrokeWidth);
        $draw->setStrokeColor(new Imagickpixel($settings->outlinecolor));
        $draw->setStrokeAntialias(true);

        $metrics = $this->baseCanvas->queryFontMetrics($draw, $this->text, false);
        $calculatedFontSize = floor($metrics['characterWidth'] * $settings->margins[$this->size] / $metrics['textWidth']);
        $newFontSize = $calculatedFontSize < $settings->fontsize[$this->size][$this->multiline] ? $calculatedFontSize : $settings->fontsize[$this->size][$this->multiline];
        $draw->setFontSize($newFontSize);

        return $draw;
    }

    /**
     * Sets ImagickDraw styling for small- or subtext
     *
     * @return ImagickDraw Styling
     */
    private function subText(): ImagickDraw
    {
        $settings = new Settings;
        $draw = new ImagickDraw();

        $draw->setGravity(Imagick::GRAVITY_CENTER);
        $draw->setFont($settings->font);
        $draw->setFillColor(new ImagickPixel($settings->subtextcolor));
        $draw->setTextAntialias(true);

        $metrics = $this->baseCanvas->queryFontMetrics($draw, $this->subtext, false);
        $calculatedFontSize = floor($metrics['characterWidth'] * $settings->margins[$this->size] / $metrics['textWidth']);
        $newFontSize = $calculatedFontSize < $settings->subfontsize[$this->size][$this->multiline] ? $calculatedFontSize : $settings->subfontsize[$this->size][$this->multiline];
        $draw->setFontSize($newFontSize);

        return $draw;
    }

    public function get()
    {
        if (! empty($this->subtext)) {
            return $this->multiLine();
        } elseif (! empty($this->text) || $this->text === '0') {
            return $this->singleLine();
        } else {
            return abort(422);
        }
    }
}
