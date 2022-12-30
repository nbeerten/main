<?php

namespace App\Classes\TMASigns;

/**
 * Settings for TMASigns
 */
class Settings
{
    public const fontsize = [
        1 => [250, 250],
        2 => [150, 150],
        4 => [200, 200],
        6 => [125, 90],
    ];

    public const subfontsize = [
        1 => [50, 50],
        2 => [50, 50],
        4 => [80, 80],
        6 => [70, 50],
    ];

    public const font = '../assets/TMASigns/Montserrat-Black.ttf';

    public const colors = [
        'green' => '#1c6f38',
        'orange' => '#f47621',
        'gold' => '#c9b12d',
        'blueish' => '#c5e9f6',
        'white' => '#ffffff',
    ];

    public const textcolor = self::colors['orange'];

    public const subtextcolor = self::colors['white'];

    public const outlinewidth = [
        1 => [5, 5],
        2 => [6, 6],
        4 => [8, 8],
        6 => [6, 5],
    ];

    public const outlinecolor = '#ffffff';

    public const base = [
        1 => '../assets/TMASigns/1x1.tga',
        2 => '../assets/TMASigns/2x1.tga',
        4 => '../assets/TMASigns/4x1.tga',
        6 => '../assets/TMASigns/6x1.tga',
    ];

    public const margins = [
        1 => 425,
        2 => 900,
        4 => 1900,
        6 => 1200,
    ];

    public const offset = [
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

    public const allowedfiletypes = ['jpg', 'webp', 'tga'];

    public const allowedsizes = [1, 2, 4, 6];

    public const skinjsonpath = '../assets/TMASigns/Skin.json';

    public const options = [
        'subtextlocation' => 'bottom',
        'offsetText' => '0',
        'offsetSubtext' => '0',
    ];
}
