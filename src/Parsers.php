<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parse(string $path): array
{
    $fileContent = file_get_contents($path);
    $fileExtension = pathinfo($path, PATHINFO_EXTENSION);
    switch ($fileExtension) {
        case "json":
            return json_decode($fileContent, true);
        case "yml":
            return Yaml::parse($fileContent);
        default:
            throw new \Exception("Files with extension '.{$fileExtension}' are not supported!");
    }
}
