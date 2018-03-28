<?php

session_start();

require_once __DIR__ . '/vendor/autoload.php';

use dominx99\school\App;

$app = (new App)->boot()->run();
