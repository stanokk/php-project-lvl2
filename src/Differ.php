<?php

namespace Differ\Differ;

use function Differ\Parsers\parse;
use function Differ\Formatters\format;

function genDiff(string $firstPath, string $secondPath, string $format = "stylish"): string
{
    $arr_1 = (parse($firstPath));
    $arr_2 = (parse($secondPath));
    $ast = compare($arr_1, $arr_2);
    return format($ast, $format);
}


function compare(array $first, array $second): array
{
    $keys = array_keys(array_merge($first, $second));
    $commonKeys = sortArray($keys);
    $buildAst = array_map(function ($key) use ($first, $second): array {
        if (array_key_exists($key, $first) && array_key_exists($key, $second)) {
            if (is_array($first[$key]) && is_array($second[$key])) {
                return makeNode('nested', $key, null, null, compare($first[$key], $second[$key]));
            } else {
                if ($first[$key] === $second[$key]) {
                    return makeNode('unchanged', $key, $second[$key], $second[$key]);
                } else {
                    return makeNode('changed', $key, $first[$key], $second[$key]);
                }
            }
        } elseif (array_key_exists($key, $first)) {
            return makeNode('removed', $key, $first[$key], '');
        } else {
            return makeNode('added', $key, '', $second[$key]);
        }
    }, $commonKeys);
    return $buildAst;
}

function makeNode(string $type, string $key, $oldValue, $newValue, $children = null): array
{
    return [
        'type' => $type,
        'node' => $key,
        'from' => $oldValue,
        'to' => $newValue,
        'children' => $children
    ];
}

function sortArray(array $arr): array
{
    sort($arr);
    return $arr;
}
