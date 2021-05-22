<?php

require_once __DIR__ . "/../../vendor/autoload.php";

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . "/../..");
$dotenv->load();

class Config
{
    const ROOT = __DIR__ . "/../..";

    const MIN_AGE = 18;

    /**
     * These Identity Providers are not allowed
     * to be accessed in a production environment
     */
    const TEST_IDP_LIST = [
        "idp_testenv2",
        "xx_servizicie_test",
    ];

    public static function is_prod(): bool
    {
        return $_ENV["ENV"] === "prod";
    }
}
