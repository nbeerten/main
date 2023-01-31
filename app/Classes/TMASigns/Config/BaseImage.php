<?php

namespace App\Classes\TMASigns\Config;

enum BaseImage: string {
    case x1 = '/assets/TMASigns/1x1.tga';
    case x2 = '/assets/TMASigns/2x1.tga';
    case x4 = '/assets/TMASigns/4x1.tga';
    case x6 = '/assets/TMASigns/6x1.tga';

    public function base_path() {
        return base_path($this->value);
    }
}