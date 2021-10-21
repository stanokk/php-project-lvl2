<?php

namespace Differ\Plain;

function plain(array $ast): string
{
    $iter = function ($ast, $parents) use (&$iter) {
        return array_reduce($ast, function ($acc, $node) use ($iter, $parents) {
            [
                'type' => $type,
                'node' => $key,
                'from' => $oldValue,
                'to' => $newValue,
                'children' => $children
            ] = $node;
            $parents[] = $key;
            $pathToNode = implode('.', $parents);
            switch ($type) {
                case 'nested':
                    $acc = array_merge($acc, $iter($children, $parents));
                    break;
                case 'added':
                    if (is_array($newValue)) {
                        $acc[] = "Property '{$pathToNode}' was added with value: " . getValue($newValue);
                    } elseif (is_bool($newValue)) {
                        $acc[] = "Property '{$pathToNode}' was added with value: " . getValue($newValue);
                    } else {
                        $acc[] = "Property '{$pathToNode}' was added with value: '{$newValue}'";
                    }
                    break;
                case 'removed':
                    $acc[] = "Property '{$pathToNode}' was removed";
                    break;
                case 'changed':
                    $from = getValue($oldValue);
                    $to = getValue($newValue);
                    $acc[] = "Property '{$pathToNode}' was updated. From $from to $to";
                    break;
            }
            return $acc;
        }, []);
    };

    return implode("\n", $iter($ast, []));
}

function getValue($value): string
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
