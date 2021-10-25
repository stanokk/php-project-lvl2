<?php

namespace Differ\Stylish;

use function Functional\concat;

function stylish(array $array): string
{
    $firstString = "{" . "\n";
    $body =  getBody($array);
    $finalString = "\n" . "}";
    return "{$firstString}{$body}{$finalString}";
}

function getBody(array $array, int $depth = 0): string
{
    $body = array_map(function ($data) use ($depth): string {
        switch ($data['type']) {
            case 'changed':
                $removed = formatRemoved($data, $depth);
                $added = formatAdded($data, $depth);
                return concat($removed, "\n", $added);
            case 'unchanged':
                return formatUnchanged($data, $depth);
            case 'removed':
                return formatRemoved($data, $depth);
            case 'added':
                return formatAdded($data, $depth);
            case 'nested':
                return formatNested($data, $depth);
        }
        return $data;
    }, $array);
    return implode("\n", $body);
}

function formatArray(array $array, int $depth): string
{
    $keys = array_keys($array);
    $viewArray = array_map(function ($key) use ($array, $depth) {
        $prefix = getIndent($depth) . '    ';
        $value = getValue($array[$key], $depth);
        return "{$prefix}{$key}: $value";
    }, $keys);
    $firstString = "{\n";
    $finalString = "\n" . getIndent($depth) . "}";
    $body = implode("\n", $viewArray);
    return "{$firstString}{$body}{$finalString}";
}


function formatRemoved(array $data, int $depth): string
{
    $prefix = getIndent($depth) . '  - ';
    $value = getValue($data['from'], $depth);
    return "{$prefix}{$data['node']}: $value";
}

function formatAdded(array $data, int $depth): string
{
    $prefix = getIndent($depth) . '  + ';
    $value = getValue($data['to'], $depth);
    return  "{$prefix}{$data['node']}: $value";
}

function formatUnchanged(array $data, int $depth): string
{
    $prefix = getIndent($depth) . '    ';
    $value = getValue($data['to'], $depth);
    return "{$prefix}{$data['node']}: $value";
}

function formatNested(array $data, int $depth): string
{
    $prefix = getIndent($depth) . '    ';
    $firstString = "{$prefix}{$data['node']}: {\n";
    $body = getBody($data['children'], $depth + 1);
    $finalString = "\n" . getIndent($depth + 1) . "}";
    return "{$firstString}{$body}{$finalString}";
}

function getIndent(int $depth): string
{
    $indent = strlen('    ') * $depth;
    return str_pad('', $indent, '    ');
}

function getValue(mixed $value, int $depth): string
{
    switch (gettype($value)) {
        case 'boolean':
            return $value ? 'true' : 'false';
        case 'array':
            return formatArray($value, $depth + 1);
        case 'NULL':
            return 'null';
        default:
            return $value;
    }
}
