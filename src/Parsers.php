<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parse(string $path): array
{
    if (!file_exists($path)) {
        throw new \Exception("Invalid file path: {$path}");
    }

    $fileContent = file_get_contents($path);
    $fileExtension = pathinfo($path, PATHINFO_EXTENSION);

    if ($fileContent === false) {
        throw new \Exception("File is unreadable: {$path}");
    }

    switch ($fileExtension) {
        case "json":
            return json_decode($fileContent, true, JSON_THROW_ON_ERROR);
        case "yml":
            return Yaml::parse($fileContent);
        case "yaml":
            return Yaml::parse($fileContent);
        default:
            throw new \Exception("Files with extension '.{$fileExtension}' are not supported!");
    }
}
