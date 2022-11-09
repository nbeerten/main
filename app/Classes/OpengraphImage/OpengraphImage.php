<?php

namespace App\Classes\OpengraphImage;

use Exception;
use Spatie\Browsershot\Browsershot;

use \Imagick as Imagick;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;

/**
 * Opengraph thumbnail generation for embedding in social media
 */
class OpengraphImage
{
    protected Imagick $overlay;
    protected Imagick $thumbnail;

    /**
     * Construct OG class
     *
     * @param string|null $url Path of request
     * @param string|null $title Big title on image
     */
    public function __construct(
        protected string $url,
        protected string|null $title,
    ) {
        match ($this->url) {
            'og' => $this->url = '',
            default => $this->url = $this->url,
        };
    }

    /**
     * Backup function to generate website preview thumbnail
     *
     * @return mixed
     */
    private function thumbnail(): self|false
    {
        $image = Browsershot::url("http://nginx/{$this->url}")
            ->windowSize(1200, 450)
            ->hideBackground()
            ->preventUnsuccessfulResponse()
            ->waitUntilNetworkIdle()
            ->noSandbox();

        $this->thumbnail = new Imagick();
        $this->thumbnail->readImageBlob($image->screenshot());
        $this->thumbnail->setImageFormat("png");

        return $this;
    }

    /**
     * Backup function to generate website preview thumbnail
     *
     * @return mixed
     */
    private function overlay(): self|false
    {
        $image = Browsershot::html(View::file(__DIR__ . '/views/opengraph.blade.php', ['title' => $this->title]))
            ->setOption('args', ['--disable-web-security'])
            ->windowSize(1200, 150)
            ->hideBackground()
            ->preventUnsuccessfulResponse()
            ->waitUntilNetworkIdle()
            ->noSandbox();

        $this->overlay = new Imagick();
        $this->overlay->readImageBlob($image->screenshot());
        $this->overlay->setImageFormat("png");

        return $this;
    }

    /**
     * Combines the image to get 1 proper
     *
     * @return mixed
     */
    protected function image() : string
    {
        $cache = $this->cachehandler();
        if ($cache !== false) {
            return $cache;
        } else {
            $this->thumbnail();
            $this->overlay();

            $image = new Imagick();
            $image->addImage($this->thumbnail);
            $image->addImage($this->overlay);
            $image->resetIterator();
            $image = $image->appendImages(true);
            $image->setImageFormat("png");
            

            $blob = $image->getImageBlob();
            
            return $this->cachehandler($blob);
        }
    }

    /**
     * Combines the image to get 1 proper
     *
     * @return mixed
     */
    protected function cachehandler(string|null $store = null): string|false
    {
        $key = json_encode([
            'url' => $this->url,
            'title' => $this->title
        ]);

        if (is_null($store)) {
            if (Cache::has($key)) {
                return Cache::get($key);
            } else {
                return false;
            }
        } else if (gettype($store) === "string") {
            Cache::put($key, $store, now()->addDays(14));
            return $store;
        }
    }

    public function get()
    {
        return $this->image();
    }
}