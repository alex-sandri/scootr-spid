<?php

require_once __DIR__ . "/../src/config/sp.php";

if (!$url = $sp->logoutPost(0))
{
    echo "Not logged in !<br>";
}
else
{
    echo $url;
}
