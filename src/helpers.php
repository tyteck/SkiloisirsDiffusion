<?php

use Dotenv\Dotenv;

function config($key)
{
    $dotenv = Dotenv::createImmutable(__DIR__.'/..');
    $dotenv->load();
    return $_ENV[strtoupper($key)] ?? $_ENV[$key];
}
