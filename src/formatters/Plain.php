<?php

namespace Differ\Plain;

use function Functional\flatten;

function plain(array $ast): string
{
    $iter = function ($ast, $parents) use (&$iter): array {
        return array_map(function ($node) use ($iter, $parents) {
            [
                'type' => $type,
                'node' => $key,
                'from' => $oldValue,
                'to' => $newValue,
                'children' => $children
            ] = $node;
            $pathToNode = implode('.', [...$parents, $key]);
            $from = getValue($oldValue);
            $to = getValue($newValue);
            switch ($type) {
                case 'nested':
                    return $iter($children, [...$parents, $key]);
                case 'added':
                    return "Property '{$pathToNode}' was added with value: $to";
                case 'removed':
                    return "Property '{$pathToNode}' was removed";
                case 'changed':
                    return "Property '{$pathToNode}' was updated. From $from to $to";
            }
        }, $ast);
    };
    $result = array_filter(flatten($iter($ast, [])));
    return implode("\n", $result);
}

function getValue(int|string|array|bool|null $value): string
{
    switch (gettype($value)) {
        case 'boolean':
            return $value ? 'true' : 'false';
        case 'array':
            return '[complex value]';
        case 'NULL':
            return 'null';
        case 'string':
            return sprintf("'%s'", $value);
        default:
            return $value;
    }
}
