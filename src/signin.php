<?php

require_once __DIR__ . "/config/sp.php";

if (!isset($_GET["idp"]) || empty($_GET["idp"]))
{
    header("Location: " . $_ENV["CLIENT_HOST"]);

    exit;
}

$idp = $_GET["idp"];

if (!$url = $sp->loginPost($idp, 0, 1, 2, null, true))
{
    echo "Already logged in !<br>";
}
else
{
    echo $url;
}
