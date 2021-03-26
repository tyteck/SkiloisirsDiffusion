<?php

use Dotenv\Dotenv;

function sldconfig($key)
{
    $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();
    return $_ENV[strtoupper($key)] ?? $_ENV[$key];
}

function generateSignature($attributes)
{
    return sha1(
        array_reduce(
            $attributes,
            function ($carry, $attribute) {
                if (strlen($carry)) {
                    $carry .= '+';
                }
                return $carry .= $attribute;
            }
        )
    );
}
