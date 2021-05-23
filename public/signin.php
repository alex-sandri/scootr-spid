<?php

require_once __DIR__ . "/../src/config/sp.php";

if (!isset($_GET["idp"]) || empty($_GET["idp"]))
{
    header("Location: " . $_ENV["CLIENT_HOST"]);

    exit;
}

$idp = $_GET["idp"];

if (!file_exists(__DIR__ . "/../idp_metadata/$idp.xml"))
{
    http_response_code(404);

    exit;
}

if (Config::is_prod() && in_array($idp, Config::TEST_IDP_LIST))
{
    http_response_code(403);

    exit;
}

if (!$url = $sp->loginPost($idp, 0, 1, 2, null, true))
{
    echo "Already logged in !<br>";
}
else
{
    echo $url;
}
