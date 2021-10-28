<?php

declare(strict_types=1);

use App\App;

require_once __DIR__.'/../vendor/autoload.php';

try {
    App::createInstance();
} catch (Exception $e) {
    echo($e->getMessage());
}
