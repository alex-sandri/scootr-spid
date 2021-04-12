<?php

require_once __DIR__ . "/config/sp.php";

if ($sp->isAuthenticated())
{
    echo "Logout failed!<br>";
}
else
{
    echo "Logout succesful!<br>";
}
