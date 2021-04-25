<?php

require_once __DIR__ . "/config/sp.php";

header("Content-type: text/xml");

echo $sp->getSPMetadata();
