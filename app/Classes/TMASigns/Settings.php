<?php

namespace App\Classes\TMASigns;

use App\Classes\TMASigns\Config\Colors;

/**
 * Settings for TMASigns
 */
class Settings
{
    public const FONT = __DIR__.'/../../../assets/TMASigns/Montserrat-Black.ttf';

    public const FONTSIZE = [
        1 => [250, 250],
        2 => [150, 150],
        4 => [200, 200],
        6 => [125, 90],
    ];

    public const SUBFONTSIZE = [
        1 => [50, 50],
        2 => [50, 50],
        4 => [80, 80],
        6 => [70, 50],
    ];

    public const COLORS = [
        'green' => Colors::Green,
        'orange' => Colors::Orange,
        'gold' => Colors::Gold,
        'blueish' => Colors::Blueish,
        'white' => Colors::White,
    ];

    public const TEXTCOLOR = Colors::Orange;

    public const SUBTEXTCOLOR = Colors::White;

    public const OUTLINEWIDTH = [
        1 => [5, 5],
        2 => [6, 6],
        4 => [8, 8],
        6 => [6, 5],
    ];

    public const OUTLINECOLOR = Colors::White;

    public const BASE = [
        1 => __DIR__.'/../../../assets/TMASigns/1x1.tga',
        2 => __DIR__.'/../../../assets/TMASigns/2x1.tga',
        4 => __DIR__.'/../../../assets/TMASigns/4x1.tga',
        6 => __DIR__.'/../../../assets/TMASigns/6x1.tga',
    ];

    public const MARGINS = [
        1 => 425,
        2 => 900,
        4 => 1900,
        6 => 1200,
    ];

    public const OFFSET = [
        'bottom' => [
            1 => [-40, 140],
            2 => [-20, 100],
            4 => [-50, 110],
            6 => [-40, 50],
        ],
        'top' => [
            1 => [10, -140],
            2 => [10, -100],
            4 => [30, -115],
            6 => [20, -65],
        ],
    ];

    public const ALLOWEDFILETYPES = ['jpg', 'webp', 'tga'];

    public const ALLOWEDSIZES = [1, 2, 4, 6];
}
