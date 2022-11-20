<?php

namespace App\Classes\Opengraph;

/**
 * Readonly class for retrieving data
 */
class Opengraphable
{
    public function __construct(
        public readonly false|string $title,
        public readonly ?string $description,
        public readonly false|string $thumbnail,
        public readonly bool $noindex

    ) {
        return $this;
    }

    public function array() : array {
        $array = array();
        foreach ($this as $key => $value) {
            $array[$key] = $value;
        }
        return $array;
    }
}