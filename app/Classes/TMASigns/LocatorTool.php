<?php

namespace App\Classes\TMASigns;

use ZipStream;

/**
 * Logic for locator tool
 */
class LocatorTool
{
    public function __construct(
        protected mixed $input
    ) {
    }

    public function get(): void
    {
        $zip = new ZipStream\ZipStream(
            outputName: 'locators.zip',
        );

        $succesfulcount = 0;
        foreach ($this->input as $url) {
            if (! filter_var($url, FILTER_VALIDATE_URL)) {
                break;
            }
            $url = trim($url);
            $url = rtrim($url, '/');
            $regex = preg_match("/[^\/]*$/", $url, $filename);
            if (! $regex) {
                break;
            }
            $zip->addFile("{$filename[0]}.loc", $url);
            $succesfulcount++;
        }

        if ($succesfulcount > 0) {
            $zip->finish();

            return;
        } else {
            abort(400);
        }
    }
}
