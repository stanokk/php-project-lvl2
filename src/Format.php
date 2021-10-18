<?php

namespace Differ\Format;

use function Differ\Stylish\stylish;

function format(array $arr, string $format): string
{
    $formats = [
        'stylish' => function ($ast) {
            return stylish($ast);
        }
    ];
    return $formats[$format]($arr);
}
