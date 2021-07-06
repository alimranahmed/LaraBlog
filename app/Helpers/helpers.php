<?php

function make_slug($title)
{
    return preg_replace("/[\s,\.]+/u", '-', strtolower($title));
}

function assoc2JsonArray(array $associativeArray): string
{
    $arrayElements = [];
    foreach ($associativeArray as $key => $value) {
        $arrayElements[] = [
            'key' => $key,
            'value' => $value,
        ];
    }
    return json_encode($arrayElements);
}

function exceptionLine(Exception $e): string
{
    return $e->getLine() . ': ' . $e->getFile() . ' ' . $e->getMessage();
}
