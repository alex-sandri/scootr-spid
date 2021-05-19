<?php

require_once __DIR__ . "/../../vendor/autoload.php";

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . "/..");
$dotenv->load();

class Config
{
    const MIN_AGE = 18;

    public static function is_prod(): bool
    {
        return $_ENV["ENV"] === "prod";
    }
}