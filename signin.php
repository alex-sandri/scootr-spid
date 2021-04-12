<?php

require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/config/sp.php";

if (isset($_GET) && isset($_GET["idp"]))
{
    $idp = $_GET["idp"];
}

if (!$url = $sp->loginPost($idp, 0, 1, 2, null, true))
{
    echo "Already logged in !<br>";
}
else
{
    echo $url;
}
