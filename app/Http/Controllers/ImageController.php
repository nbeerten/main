<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Imagick;
use Spatie\Url\Url;

class ImageController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        // Require "src" parameter
        if (empty($request->query('src'))) {
            return abort(404, "Missing 'src' query parameter");
        }

        $src = Url::fromString($request->query('src'));

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

        $w = $request->query('w');
        $h = $request->query('h');

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

                // If it still seems that the set width and height are equal to the original, still grab the original file.
                if ($imagewidth === $w && $imageheight === $h) {
                    return File::get(resource_path("images/{$src}"));
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

                // Cache for 7 days.
                $secondsToStore = 60 * 60 * 24 * 7;
                Cache::add($cacheable, $image->getImageBlob(), $secondsToStore);

                return $image->getImageBlob();
            });

        return response($output, 200, [
            'Content-Type' => 'image/webp',
            'Cache-Control' => 'public, max-age=604800',
        ]);
    }
}
