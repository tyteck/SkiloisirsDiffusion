<?php

use Dotenv\Dotenv;

function sldconfig($key)
{
    $dotenv = Dotenv::create(__DIR__ . '/../..');
    $dotenv->load();
    return $_ENV[strtoupper($key)] ?? $_ENV[$key];
}
