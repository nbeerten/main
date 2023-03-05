<?php

namespace App\Classes\TMASigns;

use App\Classes\TMASigns\Config\Colors;
use App\Classes\TMASigns\Config\Format;
use App\Classes\TMASigns\Config\Size;
use Exception;
use Imagick;
use ImagickDraw;

/**
 * Base methods for TMASigns
 */
class Base
{
    /**
     *  Easy-access variable to check if sign is multiline
     */
    protected int $isMultiline = 0;

    protected Format $format;
    protected bool $shouldOutputZip = false;
    protected Size $size;
    protected OptionsStruct $options;
    protected string $text;
    protected string|null $subtext;
    private Imagick $baseCanvas;

    /**
     * Base function to create a sign
     */
    protected function create(): self
    {
        $this->baseCanvas = new Imagick(Settings::BASE[$this->size->value]);
        $this->baseCanvas->flipImage();

        return $this;
    }

    /**
     * Create singe-line style sign
     */
    protected function singleline(): self
    {
        $this->baseCanvas->annotateImage(
            $this->text(),
            0,
            0 + ($this->options['offsetText'] ?? 0),
            0,
            $this->text
        );

        return $this;
    }

    /**
     * Create multi-line style sign
     */
    protected function multiline(): self
    {
        if (is_null($this->subtext)) {
            throw new Exception("Cannot use TMASigns\Base::multiline() method if property subtext is null");
        }

        $this->baseCanvas->annotateImage(
            $this->subText(),
            0,
            Settings::OFFSET[$this->options['subtextlocation']][$this->size->value][1] + ($this->options['offsetSubtext'] ?? 0),
            0,
            $this->subtext
        );
        $this->baseCanvas->annotateImage(
            $this->text(),
            0,
            Settings::OFFSET[$this->options['subtextlocation']][$this->size->value][0] + ($this->options['offsetText'] ?? 0),
            0,
            $this->text
        );

        return $this;
    }

    /**
     * Get blob of sign
     */
    protected function toString(): string
    {
        // Set all image-specific settings
        $this->imageSettings();

        $output = $this->baseCanvas->getImageBlob();

        $this->baseCanvas->clear();

        return $output;
    }

    /**
     * Image settings like compression, bitdepth and format.
     */
    private function imageSettings(): void
    {
        $this->baseCanvas->setImageFormat($this->format->value);

        // Specific settings for TGA files
        if ($this->format === Format::TGA) {
            $this->baseCanvas->flipImage(); // Fix for weird behaviour where TGA's are flipped on export. Don't ask why, but this works (:
            $this->baseCanvas->setImageCompression(Imagick::COMPRESSION_RLE); // Seemingly the most efficient compression for TGA
            $this->baseCanvas->setImageDepth(24); // Pixel depth of 24 bits. Meaning, only RGB supported. No alpha channel.
            $this->baseCanvas->setImageAlphaChannel(Imagick::ALPHACHANNEL_DEACTIVATE); // Somehow Trackmania still sees alpha channel, so this is neccesary.

            $this->baseCanvas->setImageCompressionQuality(100);
        }
        if ($this->format === Format::WEBP) {
            $this->baseCanvas->setImageCompression(Imagick::COMPRESSION_ZIP);
            $this->baseCanvas->setImageCompressionQuality(100);
        }
        if ($this->format === Format::JPG) {
            $this->baseCanvas->setImageCompression(Imagick::COMPRESSION_JPEG);
            $this->baseCanvas->setImageCompressionQuality(95);
        }
    }

    /**
     * Sets ImagickDraw styling for big text
     *
     * @return ImagickDraw Styling
     */
    private function text(): ImagickDraw
    {
        $draw = new ImagickDraw();

        $draw->setGravity(Imagick::GRAVITY_CENTER);
        $draw->setFont(Settings::FONT);
        $draw->setFillColor(Colors::Orange->toImagickPixel());
        $draw->setTextAntialias(true);

        $strokeWidth = ($this->size->value === 1 && strlen($this->text) <= 4) ? Settings::OUTLINEWIDTH[$this->size->value][$this->isMultiline] * 2 : Settings::OUTLINEWIDTH[$this->size->value][$this->isMultiline];
        $newStrokeWidth = round($strokeWidth + ($this->options['outlineModifier'] ?? 0), 3);
        $draw->setStrokeWidth($newStrokeWidth);
        $draw->setStrokeColor(Colors::White->toImagickPixel());
        $draw->setStrokeAntialias(true);

        $metrics = $this->baseCanvas->queryFontMetrics($draw, $this->text, false);
        $calculatedFontSize = floor($metrics['characterWidth'] * Settings::MARGINS[$this->size->value] / $metrics['textWidth']);
        $newFontSize = $calculatedFontSize < Settings::FONTSIZE[$this->size->value][$this->isMultiline] ? $calculatedFontSize : Settings::FONTSIZE[$this->size->value][$this->isMultiline];
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
        if (is_null($this->subtext)) {
            throw new Exception("Cannot use TMASigns\Base::subtext() method if property subtext is null");
        }

        $draw = new ImagickDraw();

        $draw->setGravity(Imagick::GRAVITY_CENTER);
        $draw->setFont(Settings::FONT);
        $draw->setFillColor(Colors::White->toImagickPixel());
        $draw->setTextAntialias(true);

        $metrics = $this->baseCanvas->queryFontMetrics($draw, $this->subtext, false);
        $calculatedFontSize = floor($metrics['characterWidth'] * Settings::MARGINS[$this->size->value] / $metrics['textWidth']);
        $newFontSize = $calculatedFontSize < Settings::SUBFONTSIZE[$this->size->value][$this->isMultiline] ? $calculatedFontSize : Settings::SUBFONTSIZE[$this->size->value][$this->isMultiline];
        $draw->setFontSize($newFontSize);

        return $draw;
    }
}
