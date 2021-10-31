<?php

declare(strict_types=1);

use App\App;

require_once __DIR__ . '/../vendor/autoload.php';

const ROOT_PATH = __DIR__ . '/../';
const VENDOR_PATH = __DIR__ . '/../vendor';

define("ROOT_URI", $_SERVER['REQUEST_URI']);

try {
    App::createInstance();
} catch (Exception $e) {
    /**
     * Setup debug backtrace on development (or any other) environments.
     * On production, just display a generic error.
     *
     */
    switch ($_ENV['APP_ENV']) {
        default:
        case "dev":
            $exception = get_class($e);
            echo "<h2 style='color: #2AA198'>{$exception}:</h2><i style='color: #268BD2'>{$e->getMessage()}</i>";
            d(($e->getTrace()));
            break;
        case "production":
            header('Location: /error.html', true, 301);
            die();
    }
}