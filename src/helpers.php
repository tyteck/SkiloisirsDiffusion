<?php

use Dotenv\Dotenv;

function sldconfig($key)
{
    static $dotenv = null;
    if (!is_object($dotenv)) {
        $dotenv = Dotenv::createMutable(__DIR__ . '/..');
        $dotenv->load();
    }
    return $_ENV[strtoupper($key)];
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
