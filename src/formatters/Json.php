<?php

namespace Differ\Json;

function json(array $ast): string
{
    return json_encode($ast, JSON_THROW_ON_ERROR);
}
