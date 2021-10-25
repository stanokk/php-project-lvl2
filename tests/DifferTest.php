<?php declare(strict_types=1);

namespace Differ\Phpunit\Differ;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    public function testDiff(): void
    {
        $expected = file_get_contents(__DIR__ . "/fixtures/expected.txt");
        $expectedStylish = file_get_contents(__DIR__ . "/fixtures/expectedStylish.txt");
        $expectedPlain = file_get_contents(__DIR__ . "/fixtures/expectedPlain.txt");
        $expectedJson = file_get_contents(__DIR__ . "/fixtures/expectedJson.txt");

        $firstJson = __DIR__ . "/fixtures/first.json";
        $secondJson = __DIR__ . "/fixtures/second.json";
        $result = genDiff($firstJson, $secondJson);
        $this->assertEquals($expected, $result);

        $firstYml = __DIR__ . "/fixtures/first.yml";
        $secondYml = __DIR__ . "/fixtures/second.yml";
        $resultStylish = genDiff($firstYml, $secondYml);
        $this->assertEquals($expectedStylish, $resultStylish);

        $file1Json = __DIR__ . "/fixtures/file1.json";
        $file2Json = __DIR__ . "/fixtures/file2.json";
        $resultPlain = genDiff($file1Json, $file2Json, "plain");
        $this->assertEquals($expectedPlain, $resultPlain);

        $resultJson = genDiff($file1Json, $file2Json, "json");
        $this->assertEquals($expectedJson, $resultJson);
    }
}
