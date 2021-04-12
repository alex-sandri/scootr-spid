<?php

require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/config/sp.php";

if (!$url = $sp->logoutPost(0))
{
    echo "Not logged in !<br>";
}
else
{
    echo $url;
}
