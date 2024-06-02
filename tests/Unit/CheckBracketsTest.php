<?php

function checkBrackets(string $string): bool
{
    $stack = [];
    $matches = [
        ')' => '(',
        '}' => '{',
        ']' => '[',
    ];

    $matchesFlatten = array_merge(array_keys($matches), array_values($matches));

    foreach (str_split($string) as $char) {
        if (! in_array($char, $matchesFlatten)) {
            continue;
        }

        if (isset($matches[$char])) {
            if (empty($stack) || array_pop($stack) != $matches[$char]) {
                return false;
            }
        } else {
            array_push($stack, $char);
        }
    }

    return empty($stack);
}

test('example', function (string $value, bool $result) {
    $r = checkBrackets($value);

    expect($r)->toBe($result);
})->with([
    ['value' => '(){}[]', 'return' => true],
    ['value' => '[{()}](){}', 'return' => true],
    ['value' => '[]{()', 'return' => false],
    ['value' => '[{)]', 'return' => false],
]);
