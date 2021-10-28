<?php

declare(strict_types=1);

use App\App;

require_once __DIR__.'/../vendor/autoload.php';

const VENDOR_PATH = __DIR__.'/../vendor';

try {
    App::createInstance();
} catch (Exception $e) {
    /**
     * Setup debug backtrace on development (or any other) environments.
     * On production, just display a generic error.
     *
     * @todo: Implement decent error page(s)
     */
    switch ($_ENV['APP_ENV']) {
        default:
        case "dev":
            $exception = get_class($e);
            echo "<h2 style='color: #2AA198'>{$exception}:</h2><i style='color: #268BD2'>{$e->getMessage()}</i>";
            d(($e->getTrace()));
            break;
        case "production":
            echo "<h2>Something went wrong, please contact an administrator.</h2>";
            break;
    }
}
