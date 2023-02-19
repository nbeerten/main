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

    protected false|int $widthFromArg = false;

    protected false|int $heightFromArg = false;

    public Url $src;

    public bool $external = false;

    public string $alt;

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

            $this->width = $imagewidth;
            $this->height = $imageheight;
            $this->widthFromArg = $width ?? false;
            $this->heightFromArg = $height ?? false;
        } else {
            $this->width = $width ?? null;
            $this->height = $height ?? null;
            $this->widthFromArg = $width ?? false;
            $this->heightFromArg = $height ?? false;
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
                $URLs[] = Url::fromString('/image')->withQueryParameters([
                    'src' => (string) $this->src,
                    'w' => $this->widthFromArg,
                    'h' => $this->widthFromArg * $ratio,
                ])." {$x}x";
            } elseif ($min > $width) {
                $skipped++;
            } elseif (min([$this->width, $max]) < $width) {
                break;
            } else {
                $URLs[] = Url::fromString('/image')->withQueryParameters([
                    'src' => (string) $this->src,
                    'w' => $width,
                    'h' => $width * $ratio,
                ])." {$x}x";
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
            $src = Url::fromString(route('image', absolute: false))
            ->withQueryParameter('src', $this->src);

            if ($this->widthFromArg) {
                $src = $src->withQueryParameter('w', strval($this->widthFromArg));
            }
            if ($this->heightFromArg) {
                $src = $src->withQueryParameter('h', strval($this->heightFromArg));
            }
        } else {
            $src = Url::fromString($this->src);
            if (Request::isSecure()) {
                $src->withScheme('https');
            }
        }

        $data = collect([
            'width' => $this->widthFromArg ?: $this->width,
            'height' => $this->heightFromArg ?: $this->height,
            'src' => (string) $src,
        ]);

        if (! $this->external && $this->useExperimental) {
            $data->put('srcset', $this->generateSrcSet());
        }

        return view('components.image.index', $data);
    }
}
