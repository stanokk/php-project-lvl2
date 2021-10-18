<?php

namespace Differ\Phpunit\Differ;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    public function testDiff(): void
    {
        $expected = file_get_contents(__DIR__ . "/fixtures/expected.txt");
        $expectedStylish = file_get_contents(__DIR__ . "/fixtures/expectedStylish.txt");

        $firstJson = __DIR__ . "/fixtures/first.json";
        $secondJson = __DIR__ . "/fixtures/second.json";
        $result = genDiff($firstJson, $secondJson);
        $this->assertEquals($expected, $result);

        $firstYml = __DIR__ . "/fixtures/first.yml";
        $secondYml = __DIR__ . "/fixtures/second.yml";
        $result = genDiff($firstYml, $secondYml);
        $this->assertEquals($expectedStylish, $result);
    }
}
