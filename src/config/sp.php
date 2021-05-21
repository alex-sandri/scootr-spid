<?php

require_once __DIR__ . "/../../vendor/autoload.php";
require_once __DIR__ . "/Config.php";

$dotenv = \Dotenv\Dotenv::createImmutable(Config::ROOT);
$dotenv->load();

$base = $_ENV["SP_ENTITYID"];

$settings = [
    "sp_entityid" => $base,
    "sp_key_file" => Config::ROOT . "/sp_conf/sp.key",
    "sp_cert_file" => Config::ROOT . "/sp_conf/sp.crt",
    "sp_assertionconsumerservice" => [
        $base . "/acs.php"
    ],
    "sp_singlelogoutservice" => [
        [ $base . "/slo.php", "" ],
    ],
    "sp_org_name" => "scootr",
    "sp_org_display_name" => "scootr",
    "idp_metadata_folder" => Config::ROOT . "/idp_metadata/", // Trailing slash is required
    "sp_attributeconsumingservice" => [
        [ "fiscalNumber" ],
        [ "name", "familyName", "fiscalNumber", "email", "dateOfBirth" ]
    ]
];

$sp = new \Italia\Spid\Sp($settings);
