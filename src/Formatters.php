<?php

namespace Differ\Formatters;

use function Differ\Stylish\stylish;
use function Differ\Plain\plain;

function format(array $ast, string $format): string
{
    switch ($format) {
        case 'json':
            return json($ast);
        case 'plain':
            return plain($ast);
        case 'stylish':
            return stylish($ast);
        default:
            throw new \Exception("report format '{$format}' is unsupported");
    }
}