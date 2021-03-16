<?php

use Dotenv\Dotenv;

function sldconfig($key)
{
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../..');
    $dotenv->load();
    return $_ENV[strtoupper($key)] ?? $_ENV[$key];
}
