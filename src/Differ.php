<?php

namespace Differ\Differ;

use function Differ\Parsers\parse;
use function Differ\Format\format;

function genDiff(string $firstPath, string $secondPath, string $format = "stylish"): string
{
    $arr_1 = (parse($firstPath));
    $arr_2 = (parse($secondPath));
    $ast = compare($arr_1, $arr_2);
    return format($ast, $format);
}


function compare(array $first, array $second): array
{
    $commonKeys = array_keys(array_merge($first, $second));
    sort($commonKeys);
    return array_reduce($commonKeys, function ($acc, $key) use ($first, $second) {
        if (array_key_exists($key, $first) && array_key_exists($key, $second)) {
            if (is_array($first[$key]) && is_array($second[$key])) {
                $acc[] = [
                    'type' => 'nested',
                    'node' => $key,
                    'children' => compare($first[$key], $second[$key])
                ];
            } else {
                if ($first[$key] === $second[$key]) {
                    $acc[] = [
                        'type' => 'unchanged',
                        'node' => $key,
                        'from' => $second[$key],
                        'to' => $second[$key]
                    ];
                } else {
                    $acc[] = [
                        'type' => 'changed',
                        'node' => $key,
                        'from' => $first[$key],
                        'to' => $second[$key]
                    ];
                }
            }
        } elseif (array_key_exists($key, $first)) {
            $acc[] = [
                'type' => 'removed',
                'node' => $key,
                'from' => $first[$key],
                'to' => ''
            ];
        } else {
            $acc[] = [
                'type' => 'added',
                'node' => $key,
                'from' => '',
                'to' => $second[$key]
            ];
        }
        return $acc;
    }, []);
}
