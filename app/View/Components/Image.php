<?php

namespace App\View\Components;

use Closure;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Request;
use Illuminate\View\Component;
use Spatie\Url\Url;

class Image extends Component
{
    public ?int $width = null;
    public ?int $height = null;
    public Url $src;
    public bool $external = false;
    public string $alt;

    /**
     * @var string[]
     */
    public $except = ['src', 'width', 'height'];

    /**
     * Decide if the `srcset` attribute should be used
     */
    public bool $useExperimental = false;

    /**
     * Create a new image instance.
     */
    public function __construct(string $src, string $alt, bool $useExperimental = false, ?int $width = null, ?int $height = null)
    {
        $this->src = Url::fromString($src);
        $this->alt = $alt;
        $this->useExperimental = $useExperimental;
        if (! empty($this->src->getScheme()) && ! empty($this->src->getHost())) {
            $this->external = true;
        }

        if ($this->external) {
            if (is_null($width) || is_null($height)) {
                throw new Exception("External image provided, please specify both width and height. Image source: {$this->src}");
            } else {
                $this->width = $width;
                $this->height = $height;
            }
        } else {
            [$imageWidth, $imageHeight] = getimagesize(resource_path("images/{$this->src}")) ?: throw new Exception('getimagesize() failed.');
            $widthRatio = $imageHeight / $imageWidth;
            $heightRatio = $imageWidth / $imageHeight;

            if ($width && $height) {
                if ($width / $height === $imageWidth / $imageHeight) {
                    $this->width = $width;
                    $this->height = $height;
                } else {
                    $this->width = $width;
                    $this->height = $width / $heightRatio;
                }
            } elseif ($width && is_null($height)) {
                $this->width = $width;
                $this->height = $width / $heightRatio;
            } elseif (is_null($width) && $height) {
                $this->width = $height / $widthRatio;
                $this->height = $height;
            } elseif (is_null($width) && is_null($height)) {
                $this->width = $imageWidth;
                $this->height = $imageHeight;
            }
        }
    }

    /**
     * Generate the srcset attribute.
     */
    public function generateSrcSet(): string
    {
        $URLs = [];

        $min = 128;
        $max = 3840;
        $amount = 4;

        [$imageWidth, $imageHeight] = getimagesize(resource_path("images/{$this->src}")) ?: throw new Exception('getimagesize() failed.');
        // Multiply with width
        $ratio = $this->height / $this->width;

        for ($i = 0; $i <= $amount; $i++) {
            static $skipped = 0;

            $x = ($i + 1) - $skipped;

            $factor = fn ($i) => 1 / $amount * ($i + 1);
            $width = $imageWidth * $factor($i);

            if ($this->width &&
               ($width < $imageWidth) &&
               ($imageWidth < ($imageWidth * $factor($i + 1)))) {
                $URLs[] = route('image', [
                    'src' => $this->urlFilename(
                        (string) $this->src,
                        $this->width,
                        $this->width * $ratio
                    ),
                ], absolute: false)." {$x}x";
            } elseif ($min > $width) {
                $skipped++;
            } elseif (min([$imageWidth, $max]) < $width) {
                break;
            } else {
                $URLs[] = route('image', [
                    'src' => $this->urlFilename(
                        (string) $this->src,
                        intval($width),
                        intval($width * $ratio)
                    ),
                ], absolute: false)." {$x}x";
            }
        }

        $output = '';
        foreach ($URLs as $key => $url) {
            $output .= "{$url}";
            if ($key !== array_key_last($URLs)) {
                $output .= ', ';
            }
        }

        return $output;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        // Assign source if source isn't external
        if (! $this->external) {
            $src = route('image',
                [
                    'src' => $this->urlFilename(
                        (string) $this->src,
                        $this->width,
                        $this->height
                    ),
                ], absolute: false);
        }
        // Assign source if source is external
        else {
            $src = Url::fromString($this->src);
            if (Request::isSecure()) {
                $src->withScheme('https');
            }
        }

        $data = collect([
            'src' => $src,
            'width' => $this->width,
            'height' => $this->height,
        ]);

        if (! $this->external && $this->useExperimental) {
            $data->put('srcset', $this->generateSrcSet());
        }

        return view('components.image.index', $data);
    }

    public function urlFilename(string $filename, ?int $w = null, ?int $h = null): string
    {
        if ((! empty($w) && empty($h)) || (! empty($h) && empty($w))) {
            throw new Exception('Please specify both width and height or neither.');
        }

        $withoutWidthAndHeight = false;
        if (empty($w) && empty($h)) {
            $withoutWidthAndHeight = true;
        }

        preg_match('/^(.*)(\..{1,16})$/i', $filename, $filenameWithExt);
        array_splice($filenameWithExt, 0, 1);
        [$partFilename, $partExt] = $filenameWithExt;
        if ($withoutWidthAndHeight) {
            $finalFilename = $partFilename.$partExt;
        } elseif (! $withoutWidthAndHeight) {
            $finalFilename = "{$partFilename}_{$w}x{$h}{$partExt}";
        }

        return $finalFilename;
    }
}
