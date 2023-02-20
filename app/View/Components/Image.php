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

    protected ?int $widthFromArg = null;

    protected ?int $heightFromArg = null;

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

        if (! $this->external) {
            if (! file_exists(resource_path("images/{$this->src}"))) {
                throw new Exception('Image not found: '.resource_path("images/{$this->src}"));
            }

            [$imagewidth, $imageheight] = getimagesize(resource_path("images/{$this->src}"));

            $heightratio = $imageheight / $imagewidth;
            $widthratio = $imagewidth / $imageheight;

            $this->width = $imagewidth;
            $this->height = $imageheight;
            $this->widthFromArg = $width ?? $imagewidth * $heightratio;
            $this->heightFromArg = $height ?? $imageheight * $widthratio;
        } else {
            $this->width = $width ?? null;
            $this->height = $height ?? null;
            $this->widthFromArg = $width ?? null;
            $this->heightFromArg = $height ?? null;
        }
    }

    /**
     * Create a new component instance.
     */
    public function generateSrcSet(): string
    {
        $URLs = [];

        $min = 128;
        $max = 3840;
        $amount = 4;

        // Multiply with width
        $ratio = $this->height / $this->width;

        for ($i = 0; $i <= $amount; $i++) {
            static $skipped = 0;

            $x = ($i + 1) - $skipped;

            $factor = fn ($i) => 1 / $amount * ($i + 1);
            $width = $this->width * $factor($i);

            if ($this->widthFromArg &&
               ($width < $this->widthFromArg) &&
               ($this->widthFromArg < ($this->width * $factor($i + 1)))) {
                $URLs[] = route('image', [
                    'src' => $this->urlFilename(
                        (string) $this->src, 
                        $this->widthFromArg,
                        $this->widthFromArg * $ratio
                    )
                ], absolute: false)." {$x}x";
            } elseif ($min > $width) {
                $skipped++;
            } elseif (min([$this->width, $max]) < $width) {
                break;
            } else {
                $URLs[] = route('image', [
                    'src' => $this->urlFilename(
                        (string) $this->src, 
                        intval($width),
                        intval($width * $ratio)
                    )
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
        if (! $this->external) {
            $src = route('image', [
                'src' => $this->urlFilename(
                    (string) $this->src, 
                    $this->widthFromArg,
                    $this->heightFromArg
                )
            ], absolute: false);
        } else {
            $src = Url::fromString($this->src);
            if (Request::isSecure()) {
                $src->withScheme('https');
            }
        }

        $data = collect([
            'width' => $this->widthFromArg ?: $this->width,
            'height' => $this->heightFromArg ?: $this->height,
            'src' => $src,
        ]);

        if (! $this->external && $this->useExperimental) {
            $data->put('srcset', $this->generateSrcSet());
        }

        return view('components.image.index', $data);
    }    
    
    public function urlFilename(string $filename, ?int $w = null, ?int $h = null): string {
        if((!empty($w) && empty($h)) || (!empty($h) && empty($w)))
            throw new Exception('Please specify both width and height or neither.');
        
        $withoutWidthAndHeight = false;
        if(empty($w) && empty($h)) $withoutWidthAndHeight = true;
        
        preg_match('/^(.*)(\..{1,16})$/i', $filename, $filenameWithExt);
        array_splice($filenameWithExt, 0, 1);
        [$partFilename, $partExt] = $filenameWithExt;
        if($withoutWidthAndHeight) $finalFilename = $partFilename . $partExt;
        elseif(! $withoutWidthAndHeight) $finalFilename = "{$partFilename}_{$w}x{$h}{$partExt}";
        
        return $finalFilename;
    }
}
