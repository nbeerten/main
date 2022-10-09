<?php

namespace App\Classes\TMASigns;

/**
 * Settings for TMASigns
 */
class Settings
{
    public const fontsize = [
        1 => 250,
        2 => 150,
        4 => 200,
        6 => 125
    ];
    public const subfontsize = [
        1 => 50,
        2 => 50,
        4 => 80,
        6 => 75
    ];
    public const font = "../assets/TMASigns/Montserrat-Black.ttf";
    public const colors = [
        "green" => '#1c6f38',
        "orange" => "#f5751c",
        "gold" => "#c9b12d",
        "blueish" => "#c5e9f6",
        "white" => "#ffffff"
    ];
    public const textcolor = self::colors["orange"];
    public const subtextcolor = self::colors["white"];
    public const outlinewidth = [
        1 => 5,
        2 => 6,
        4 => 8,
        6 => 6
    ];
    public const suboutlinewidth = [
        1 => 0,
        2 => 0,
        4 => 0,
        6 => 0
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
    public const offset = [
        1 => [-20, 120],
        2 => [-20, 100],
        4 => [-50, 110],
        6 => [0, 0] // Not needed
    ];
    public const allowedfiletypes = ["jpg", "tga"];
    public const allowedsizes = [1, 2, 4, 6];
    public const skinjsonpath = "../assets/TMASigns/Skin.json";
}