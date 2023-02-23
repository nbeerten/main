<?php

namespace App\Classes\TMASigns\Config;

use ImagickPixel;

enum Colors: string
{
    case Green = '#1c6f38';
    case Orange = '#f47621';
    case Gold = '#c9b12d';
    case Blueish = '#c5e9f6';
    case White = '#ffffff';

    public function toImagickPixel(): ImagickPixel
    {
        return new ImagickPixel($this->value);
    }
}
