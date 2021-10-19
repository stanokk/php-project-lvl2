<?php

namespace Differ\Plain;

function plain(array $ast)
{
    $iter = function ($ast, $parents) use (&$iter) {
        return array_reduce($ast, function ($acc, $node) use ($iter, $parents) {
            $parents[] = $node['node'];
            $pathToNode = implode('.', $parents);
            switch ($node['type']) {
                case 'nested':
                    $acc = array_merge($acc, $iter($node['children'], $parents));
                    break;
                case 'added':
                    if (is_array($node['to'])) {
                        $acc[] = "Property '{$pathToNode}' was added with value: " . getValue($node['to']);
                    } elseif (is_bool($node['to'])) {
                        $acc[] = "Property '{$pathToNode}' was added with value: " . getvalue($node['to']);
                    } else {
                        $acc[] = "Property '{$pathToNode}' was added with value: '{$node['to']}'";
                    }
                    break;
                case 'removed':
                    $acc[] = "Property '{$pathToNode}' was removed";
                    break;
                case 'changed':
                    $from = getValue($node['from']);
                    $to = getValue($node['to']);
                    $acc[] = "Property '{$pathToNode}' was updated. From '{$from}' to '{$to}'";
                    break;
            }
            return $acc;
        }, []);
    };

    return implode("\n", $iter($ast, [])) . "\n";
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
        default:
            return $value;
    }
}
