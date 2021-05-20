<?php

require_once __DIR__ . "/../src/config/sp.php";

if ($sp->getAttributes())
{
    $connection = pg_connect($_ENV["DATABASE_CONNECTION_STRING"]);

    // The fiscal number is returned in the format TINIT-FISCALNUMBER
    $fiscal_number = explode("-", $sp->getAttributes()["fiscalNumber"])[1];

    $result = pg_query_params(
        $connection,
        '
        select "id"
        from "users"
        where "fiscal_number" = $1
        limit 1
        ',
        [ $fiscal_number ]
    );

    if (pg_numrows($result) > 0)
    {
        $user_id = pg_fetch_row($result)[0];

        pg_query_params(
            $connection,
            '
            delete from "sessions"
            where "user" = $1
            ',
            [ $user_id ]
        );
    }
}

// Called to complete the logout process
$sp->isAuthenticated();
