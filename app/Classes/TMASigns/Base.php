<?php

namespace App\Classes\TMASigns;

use App\Classes\TMASigns\Config\Colors;
use App\Classes\TMASigns\Config\Format;
use App\Classes\TMASigns\Config\Size;
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
    protected int $multiline = 0;

    protected Format $format;

    protected Size $size;

    protected array|null $options;

    protected string $text;

    protected string|null $subtext;

    private Imagick $baseCanvas;

    private ImagickDraw $textStyling;

    private ImagickDraw|null $subTextStyling;

    public function get()
    {
        if (! empty($this->subtext)) {
            return $this->create()->multiline()->toString();
        } elseif (! empty($this->text) || $this->text === '0') {
            return $this->create()->singleline()->toString();
        } else {
            return abort(422);
        }
    }

    /**
     * Base function to create a sign
     *
     * @return Imagick
     */
    private function create(): self
    {
        $this->baseCanvas = new Imagick(Settings::BASE[$this->size->value]);
        $this->baseCanvas->flipImage();

        $this->textStyling = $this->text();
        if ($this->multiline) {
            $this->subTextStyling = $this->subText();
        }

        return $this;
    }

    /**
     * Create singe-line style sign
     *
     * @return string Blob of single-line sign
     */
    private function singleline(): self
    {
        $this->baseCanvas->annotateImage(
            $this->textStyling,
            0,
            0 + ($this->options['offsetText'] ?? 0),
            0,
            $this->text
        );

        return $this;
    }

    /**
     * Create multi-line style sign
     *
     * @return string Blob of multi-line sign
     */
    private function multiline(): self
    {
        $this->baseCanvas->annotateImage(
            $this->subTextStyling,
            0,
            Settings::OFFSET[$this->options['subtextlocation']][$this->size->value][1] + ($this->options['offsetSubtext'] ?? 0),
            0,
            $this->subtext
        );
        $this->baseCanvas->annotateImage(
            $this->textStyling,
            0,
            Settings::OFFSET[$this->options['subtextlocation']][$this->size->value][0] + ($this->options['offsetText'] ?? 0),
            0,
            $this->text
        );

        return $this;
    }

    /**
     * Get blob of sign
     *
     * @return string Blob of sign
     */
    public function toString(): string
    {
        // Set all image-specific settings
        $this->imageSettings();

        if ($this->format === Format::TGA) {
            $this->baseCanvas->flipImage();
        }

        $output = $this->baseCanvas->getImageBlob();

        $this->baseCanvas->clear();
        $this->textStyling->clear();
        if ($this->multiline) {
            $this->subTextStyling->clear();
        }

        return $output;
    }

    /**
     * Image settings like compression, bitdepth and format.
     */
    private function imageSettings(): void
    {
        $this->baseCanvas->setImageFormat($this->format->value);

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
     * Sets ImagickDraw styling for big text
     *
     * @return ImagickDraw Styling
     */
    private function text(): ImagickDraw
    {
        $draw = new ImagickDraw();

        $draw->setGravity(Imagick::GRAVITY_CENTER);
        $draw->setFont(Settings::FONT);
        $draw->setFillColor(Colors::Orange->ImagickPixel());
        $draw->setTextAntialias(true);

        $strokeWidth = ($this->size->value === 1 && strlen($this->text) <= 4) ? Settings::OUTLINEWIDTH[$this->size->value][$this->multiline] * 2 : Settings::OUTLINEWIDTH[$this->size->value][$this->multiline];
        $newStrokeWidth = round($strokeWidth + ($this->options['outlineModifier'] ?? 0), 3);
        $draw->setStrokeWidth($newStrokeWidth);
        $draw->setStrokeColor(Colors::White->ImagickPixel());
        $draw->setStrokeAntialias(true);

        $metrics = $this->baseCanvas->queryFontMetrics($draw, $this->text, false);
        $calculatedFontSize = floor($metrics['characterWidth'] * Settings::MARGINS[$this->size->value] / $metrics['textWidth']);
        $newFontSize = $calculatedFontSize < Settings::FONTSIZE[$this->size->value][$this->multiline] ? $calculatedFontSize : Settings::FONTSIZE[$this->size->value][$this->multiline];
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
        $draw = new ImagickDraw();

        $draw->setGravity(Imagick::GRAVITY_CENTER);
        $draw->setFont(Settings::FONT);
        $draw->setFillColor(Colors::White->ImagickPixel());
        $draw->setTextAntialias(true);

        $metrics = $this->baseCanvas->queryFontMetrics($draw, $this->subtext, false);
        $calculatedFontSize = floor($metrics['characterWidth'] * Settings::MARGINS[$this->size->value] / $metrics['textWidth']);
        $newFontSize = $calculatedFontSize < Settings::SUBFONTSIZE[$this->size->value][$this->multiline] ? $calculatedFontSize : Settings::SUBFONTSIZE[$this->size->value][$this->multiline];
        $draw->setFontSize($newFontSize);

        return $draw;
    }
}
