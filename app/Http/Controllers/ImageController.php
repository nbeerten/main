<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Imagick;
use Spatie\Url\Url;

class ImageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, ?string $src = null): Response|RedirectResponse
    {
        // Somehow the result of `preg_match` is usable within the if block.
        if (empty($request->query('src')) && ! empty($src) &&
            preg_match('/^(.*)(?:_(?:([0-9]+)x([0-9]+))(\..{1,16}))$/i', $src, $matches)
        ) {
            array_splice($matches, 0, 1);
            [$filename, $w, $h, $ext] = $matches;
            $w = intval($w);
            $h = intval($h);

            $src = Url::fromString($filename.$ext);
        } elseif (empty($request->query('src')) && ! empty($src) &&
            preg_match('/^(.*)(\..{1,16})$/i', $src, $matches)
        ) {
            array_splice($matches, 0, 1);
            [$filename, $ext] = $matches;

            $src = Url::fromString($filename.$ext);
            $w = null;
            $h = null;
        } else {
            $src = Url::fromString($request->query('src') ?? '');
            $w = intval($request->query('w'));
            $h = intval($request->query('h'));
        }

        // Require "src" parameter
        if (empty((string) $src)) {
            return abort(404, "Missing 'src' query parameter");
        }

        if (! empty($src->getScheme()) && ! empty($src->getHost())) {
            return redirect($src, secure: true);
        }

        // Check if file exists, and then make sure that the file exists in the "resources/images/" directory, to prevent abuse like "resources/images/../../.env"
        if (! file_exists(resource_path("images/{$src}"))) {
            return abort(404, 'Image not found');
        }
        if (strncmp(realpath(resource_path("images/{$src}")), resource_path('images'), strlen(resource_path('images'))) !== 0) {
            return abort(404, 'Illegal URL used.');
        }

        // Check if width or height aren't above max limit
        $max = 7680;
        if (($w > $max || $h > $max)) {
            return abort(400, "Width or height exceeds maximum of {$max}");
        }

        // Generate a hash from the input (src, w, h)
        $cacheable = json_encode([
            'src' => (string) $src,
            'w' => (int) $w,
            'h' => (int) $h,
        ]);
        $cacheable = Str::of($cacheable)->pipe('md5')->prepend('image:');

        // Either grab the cached file, or generate a new file.
        $output = Cache::get($cacheable,
            function () use ($cacheable, $src, $w, $h): string {
                // How long to store in cache: currently for 7 days.
                $secondsToStore = 60 * 60 * 24 * 7;

                // Check if height and width are empty, if so, just grab the original file.
                if (empty($w) && empty($h)) {
                    return File::get(resource_path("images/{$src}"));
                }

                // A way more performant way of grabbing image size compared to using Imagick.
                [$imagewidth, $imageheight] = getimagesize(resource_path("images/{$src}"));

                // If either width or height weren't set/known *yet*, get the correct width/height from the imagick object.
                if (empty($w)) {
                    $w = $imagewidth;
                }
                if (empty($h)) {
                    $h = $imageheight;
                }

                // Don't accept that the given $w or $h is bigger then the image itself (no upscaling)
                if ($w > $imagewidth) {
                    $w = $imagewidth;
                }
                if ($h > $imageheight) {
                    $h = $imageheight;
                }

                // If it still seems that the set width and height are equal to the original, still grab the original file and store in cache.
                if ($imagewidth === intval($w) && $imageheight === intval($h)) {
                    $fileContents = File::get(resource_path("images/{$src}"));
                    Cache::add($cacheable, $fileContents, $secondsToStore);

                    return $fileContents;
                }

                // If it seems that the size is actually different, create an Imagick object, and start resizing.
                $image = new Imagick(resource_path("images/{$src}"));

                $image->setImageFormat('webp');

                // Calculate the aspect ratio of the image, and then check if height is missing or is incorrect, to then correct it.
                $heightratio = $image->getImageHeight() / $image->getImageWidth();
                if ($h / $w != $heightratio) {
                    $h = $w * $heightratio;
                }
                // Do the same if the width is missing or incorrect
                $widthratio = $image->getImageWidth() / $image->getImageHeight();
                if ($w / $h != $widthratio) {
                    $w = $h * $widthratio;
                }

                $image->setImageCompressionQuality(95);
                // Idk what it does exactly, but why not
                $image->setOption('webp:exact', 'true');
                // Calculate target file size. Width times 50 is roughly: 256x256=12kb, 500x500=25kb, etc.
                $image->setOption('webp:target-size', strval($w * 50));
                $image->resizeImage($w, $h, Imagick::FILTER_LANCZOS, 1);

                // Add to cache
                Cache::add($cacheable, $image->getImageBlob(), $secondsToStore);

                return $image->getImageBlob();
            });

        return response($output, 200, [
            'Content-Type' => 'image/webp',
            'Cache-Control' => 'public, max-age=604800',
        ]);
    }
}
