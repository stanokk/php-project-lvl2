<?php

namespace Differ\Differ;

use function Differ\Parsers\parse;

function genDiff(string $firstPath, string $secondPath): string
{
    $arr_1 = (parse($firstPath));
    $arr_2 = (parse($secondPath));
    $arr_3 = array_merge($arr_1, $arr_2);
    $arr_4 = array_keys($arr_3);
    sort($arr_4);
    return compare($arr_4, $arr_1, $arr_2);
}


function compare(array $commonKeys, array $first, array $second): string
{
    $first = boolAsString($first);
    $second = boolAsString($second);
    $result = '';
    foreach ($commonKeys as $key) {
        if (array_key_exists($key, $first) && array_key_exists($key, $second) && $first[$key] === $second[$key]) {
            $result = $result . "  " . $key . ": " . $first[$key] . "\n";
        } elseif (array_key_exists($key, $first) && array_key_exists($key, $second) && $first[$key] !== $second[$key]) {
            $result = $result . " -" . $key . ": " . $first[$key] . "\n" . " +" . $key . ": " . $second[$key] . "\n";
        } elseif (array_key_exists($key, $first) && !array_key_exists($key, $second)) {
            $result = $result . " -" . $key . ": " . $first[$key] . "\n";
        } elseif (!array_key_exists($key, $first) && array_key_exists($key, $second)) {
            $result = $result . " +" . $key . ": " . $second[$key] . "\n";
        }
    }
    return "{" . "\n" . $result . "}" . "\n";
}


function boolAsString(array $array): array
{
    return array_map(function ($value) {
        if ($value === true) {
            $value = "true";
        } elseif ($value === false) {
            $value = "false";
        }
        return $value;
    }, $array);
}
