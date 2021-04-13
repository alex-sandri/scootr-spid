<?php

require_once __DIR__ . "/config/sp.php";

if ($sp->getAttributes())
{
    // The fiscal number is returned in the format TINIT-FISCALNUMBER
    $fiscal_number = explode("-", $sp->getAttributes()["fiscalNumber"])[1];

    // TODO
    // Delete all sessions associated with this user
}

// Called to complete the logout process
$sp->isAuthenticated();
