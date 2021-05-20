<?php

require_once __DIR__ . "/../src/config/sp.php";

header("Content-type: text/xml");

echo $sp->getSPMetadata();
