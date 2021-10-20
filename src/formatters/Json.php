<?php

namespace Differ\Json;

function json($ast)
{
    return json_encode($ast, JSON_THROW_ON_ERROR);
}
