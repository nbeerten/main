<?php

namespace App\Classes\OpengraphImage;

use Exception;
use Spatie\Browsershot\Browsershot;
use Spatie\Image\Manipulations;

use \Imagick as Imagick;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Opengraph thumbnail generation for embedding in social media
 */
class OpengraphImage
{
    protected Imagick $overlay;
    protected Imagick $thumbnail;

    private const BASEURL = "http://nginx/";

    private const BLOCKLIST = [ "cloudflareinsights.com" ];
    private const ARGS = [
        "no-sandbox",
        "disable-setuid-sandbox",
        "disable-infobars",
        "single-process",
        "no-zygote",
        "no-first-run",
        "window-position" => "0,0",
        "ignore-certificate-errors",
        "ignore-certificate-errors-skip-list",
        "disable-dev-shm-usage",
        "disable-accelerated-2d-canvas",
        "disable-gpu",
        "hide-scrollbars",
        "disable-notifications",
        "disable-background-timer-throttling",
        "disable-backgrounding-occluded-windows",
        "disable-breakpad",
        "disable-component-extensions-with-background-pages",
        "disable-extensions",
        "disable-features" => "TranslateUI,BlinkGenPropertyTrees",
        "disable-ipc-flooding-protection",
        "disable-renderer-backgrounding",
        "enable-features" => "NetworkService,NetworkServiceInProcess",
        "force-color-profile" => "srgb",
        "metrics-recording-only",
        "mute-audio"
      ];

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
        $image = Browsershot::url(self::BASEURL . $this->url)
            ->userAgent("OpengraphImage (" . env('APP_URL') . ")")
            ->mobile()
            ->windowSize(1200, 450)
            ->disableJavascript()
            ->blockDomains(self::BLOCKLIST)
            ->setOption('addStyleTag', json_encode(['content' => 'nav { display: none; }']))
            ->preventUnsuccessfulResponse()
            ->noSandbox()
            ->addChromiumArguments(self::ARGS);

        $this->thumbnail = new Imagick();
        $this->thumbnail->readImageBlob($image->screenshot());
        $this->thumbnail->setImageFormat("jpg");

        return $this;
    }

    /**
     * Backup function to generate website preview thumbnail
     *
     * @return mixed
     */
    private function overlay(): self|false
    {
        $image = Browsershot::html(View::file(__DIR__ . '/views/opengraph.blade.php', ['title' => $this->title, 'baseurl' => self::BASEURL]))
            ->windowSize(1200, 150)
            ->hideBackground()
            ->preventUnsuccessfulResponse()
            ->noSandbox()
            ->addChromiumArguments(self::ARGS)
            ->setOption('args', ['--disable-web-security']);

        $this->overlay = new Imagick();
        $this->overlay->readImageBlob($image->screenshot());
        $this->overlay->setImageFormat("jpg");

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
            $image->setImageFormat("jpg");
            

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
