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

    public function get(): ?mixed
    {
        $zip = new ZipStream\ZipStream('locators.zip');

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
            return abort(400);
        }
    }
}
