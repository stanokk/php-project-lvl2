<?php

namespace Differ\Phpunit\Differ;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    public function testDiff(): void
    {
        $expected = file_get_contents(__DIR__ . "/fixtures/expected.txt");
        $first = __DIR__ . "/fixtures/first.json";
        $second = __DIR__ . "/fixtures/second.json";
        $result = genDiff($first, $second);
        $this->assertEquals($expected, $result);
    }
}
