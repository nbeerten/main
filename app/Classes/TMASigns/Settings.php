<?php

namespace App\Classes\TMASigns;

/**
 * Settings for TMASigns
 */
class Settings
{
    public const fontsize = [
        1 => 100,
        2 => 150,
        4 => 200,
        6 => 125
    ];
    public const subfontsize = [
        1 => 50,
        2 => 75,
        4 => 80,
        6 => 75
    ];
    public const font = "../assets/TMASigns/Montserrat-Black.ttf";
    public const textcolor = '#f37520';
    public const outlinewidth = [
        1 => 2,
        2 => 3,
        4 => 4,
        6 => 3
    ];
    public const outlinecolor = "#ffffff";
    public const base = [
        1 => '../assets/TMASigns/1x1.tga',
        2 => '../assets/TMASigns/2x1.tga',
        4 => '../assets/TMASigns/4x1.tga',
        6 => '../assets/TMASigns/6x1.tga'
    ];
    public const margins = [
        1 => 425,
        2 => 900,
        4 => 1900,
        6 => 1400
    ];
    public const allowedfiletypes = ["jpg", "tga"];
    public const allowedsizes = [1, 2, 4, 6];
    public const skinjsonpath = "../assets/TMASigns/Skin.json";
}