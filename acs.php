<?php

require_once(__DIR__ . "/vendor/autoload.php");
require_once(__DIR__ . "/sp_conf/config.php");

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$base = $_ENV["SP_ENTITYID"];
$settings = [
    "sp_entityid" => $base,
    "sp_key_file" => "./sp_conf/sp.key",
    "sp_cert_file" => "./sp_conf/sp.crt",
    "sp_assertionconsumerservice" => [
        $base . "/acs.php"
    ],
    "sp_singlelogoutservice" => [[$base . "/slo.php", ""]],
    "sp_org_name" => "scootr",
    "sp_org_display_name" => "scootr",
    "idp_metadata_folder" => "./sp_conf/",
    "sp_attributeconsumingservice" => [
        [ "fiscalNumber" ],
        [ "name", "familyName", "fiscalNumber", "email", "dateOfBirth" ]
    ]
];

$sp = new \Italia\Spid\Sp($settings);

if ($sp->isAuthenticated())
{
    $connection = pg_connect($_ENV["DATABASE_CONNECTION_STRING"]);

    $first_name = $sp->getAttributes()["name"];
    $last_name = $sp->getAttributes()["familyName"];
    $email = $sp->getAttributes()["email"];
    $birth_date = $sp->getAttributes()["dateOfBirth"];
    // The fiscal number is returned in the format TINIT-FISCALNUMBER
    $fiscal_number = explode("-", $sp->getAttributes()["fiscalNumber"])[1];

    $result = pg_query_params(
        $connection,
        '
        select "id"
        from "users"
        where "email" = $1
        limit 1
        ',
        [ $email ]
    );

    if (pg_numrows($result) === 0)
    {
        $user_id = "usr_" . \EndyJasmi\Cuid::cuid();

        pg_query("begin");

        try
        {
            pg_query_params(
                $connection,
                '
                insert into "users"
                    ("id", "first_name", "last_name", "email", "birth_date", "fiscal_number")
                values
                    ($1, $2, $3, $4, $5, $6)
                ',
                [
                    $user_id,
                    $first_name,
                    $last_name,
                    $email,
                    $birth_date,
                    $fiscal_number,
                ]
            );

            $stripe = new \Stripe\StripeClient($_ENV["STRIPE_SECRET_API_KEY"]);

            $stripe->customers->create([
                "name" => $first_name . " " . $last_name,
                "email" => $email,
                "metadata" => [
                    "user_id" => $user_id,
                ],
            ]);

            pg_query("commit");
        }
        catch (Exception $e)
        {
            pg_query("rollback");

            exit;
        }
    }
    else
    {
        $user_id = pg_fetch_row($result)[0];
    }

    $session_id = "ses_" . \EndyJasmi\Cuid::cuid();
    $session_expires_at = time() + 60 * 60 * 24 * 30;

    try
    {
        pg_query_params(
            $connection,
            '
            insert into "sessions"
                ("id", "user", "expires_at")
            values
                ($1, $2, $3)
            ',
            [
                $session_id,
                $user_id,
                $session_expires_at,
            ]
        );
    }
    catch (Exception $e)
    {
        exit;
    }

    setcookie(
        "session_id",
        $session_id,
        $session_expires_at,
        "/",
        $_ENV["ENV"] === "prod" ? $_ENV["CLIENT_HOST"] : false,
        $_ENV["ENV"] === "prod",
        true
    );

    header("Location: " . $_ENV["CLIENT_HOST"]);
}
else
{
    echo "Not logged in !<br>";
    echo "<a href=\"/login\">Login</a>";
}
