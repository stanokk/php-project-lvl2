<?php

function parse(string $string)
{
    $array = json_decode($string, true);
    return $array;
}


$example_1 =
'{
  "host": "hexlet.io",
  "timeout": 50,
  "proxy": "123.234.53.22",
  "follow": false
}';

$example_2 =
'{
  "timeout": 20,
  "verbose": true,
  "host": "hexlet.io"
}';


$arr_1 = (parse($example_1));
$arr_2 = (parse($example_2));
ksort($arr_1);
ksort($arr_2);
var_dump($arr_1);
var_dump($arr_2);

function boolToString(array $array)
{
    return array_map(function ($value) {
        if ($value === true) {
            $value = "true";
        } elseif ($value === false) {
            $value = "false";
        }
        return $value;
    }, $array);
}

function getSameElements(array $array_1, array $array_2)
{
    $same = array_intersect($array_1, $array_2);
    $item = [];
    foreach ($same as $key => $value) {
        $item = [$key => $value];
    }
    return $item;
}

function getOnlyFirstElements(array $arr1, array $arr2)
{
    $onlyFirst = array_diff_key($arr1, $arr2);
    //$onlyFirst = boolToString($onlyFirst);
    $item = [];
    foreach($onlyFirst as $key => $value) {
        $item[$key] = $value;
    }
    return $item;
}

function getOnlySecondElements(array $arr1, array $arr2)
{
    $onlySecond = array_diff_key($arr2, $arr1);
    //$onlySecond = boolToString($onlySecond);
    $item = [];
    foreach($onlySecond as $key => $value) {
        $item[$key] = $value;
    }
    return $item;
}

function getCommonElements(array $arr1, array  $arr2)
{
    $item = '';
    foreach ($arr1 as $key => $value) {
        if (array_key_exists($key, $arr2) && $arr1[$key] !== $arr2[$key]) {
            $item = $item . "- " . $key . ": " . $value . "\n" . "+ " . $key . ": " . $arr2[$key] . "\n";
        }
    }
    return $item;
}
$common = getCommonElements($arr_1, $arr_2);
var_dump($common);
$same = getSameElements($arr_1, $arr_2);
var_dump($same);
$onlyFirst = getOnlyFirstElements($arr_1, $arr_2);
var_dump($onlyFirst);
$onlySecond = getOnlySecondElements($arr_1, $arr_2);
var_dump($onlySecond);

//$result = $same . $onlyFirst . $onlySecond . $common;
//var_dump($result);



