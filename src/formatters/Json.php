<?php

namespace Differ\Json;

function json($ast)
{
    return json_encode($ast, JSON_PRETTY_PRINT) . "\n";
}
