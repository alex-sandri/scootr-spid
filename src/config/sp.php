<?php

require_once __DIR__ . "/../../vendor/autoload.php";

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . "/..");
$dotenv->load();

$base = $_ENV["SP_ENTITYID"];

$settings = [
    "sp_entityid" => $base,
    "sp_key_file" => __DIR__ . "/../sp_conf/sp.key",
    "sp_cert_file" => __DIR__ . "/../sp_conf/sp.crt",
    "sp_assertionconsumerservice" => [
        $base . "/acs.php"
    ],
    "sp_singlelogoutservice" => [
        [ $base . "/slo.php", "" ],
    ],
    "sp_org_name" => "scootr",
    "sp_org_display_name" => "scootr",
    "idp_metadata_folder" => __DIR__ . "/../idp_metadata/",
    "sp_attributeconsumingservice" => [
        [ "fiscalNumber" ],
        [ "name", "familyName", "fiscalNumber", "email", "dateOfBirth" ]
    ]
];

$sp = new \Italia\Spid\Sp($settings);
