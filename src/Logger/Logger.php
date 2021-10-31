<?php

declare(strict_types=1);

namespace App\Logger;

use App\Interface\LoggerInterface;
use Monolog\ErrorHandler;
use Monolog\Handler\StreamHandler;

/**
 * Logger
 *
 * @author <andy.rotsaert@live.be>
 */
final class Logger extends \Monolog\Logger implements LoggerInterface
{
    /**
     * @var array
     */
    private array $loggers = [];

    /**
     * @var string
     */
    private string $logPath;

    /**
     * @param string $key
     * @param int $logLevel
     */
    public function __construct(string $key = "app", int $logLevel = \Monolog\Logger::DEBUG)
    {
        parent::__construct($key);

        $this->logPath = dirname($_SERVER['DOCUMENT_ROOT']) . $_ENV['LOG_PATH'];
        $this->pushHandler(new StreamHandler($this->logPath . "/{$key}.log", $logLevel));
    }

    /**
     * Setup error and request logs.
     *
     * @return void
     */
    public function enableSystemLogs(): void
    {
        $this->loggers['error'] = new Logger('errors');
        $this->loggers['error']->pushHandler(new StreamHandler("{$this->logPath}/errors.log"));
        ErrorHandler::register($this->loggers['error']);

        $data = [
            $_SERVER,
            $_REQUEST,
            trim(file_get_contents("php://input")),
        ];
        $this->loggers['request'] = new Logger('request');
        $this->loggers['request']->pushHandler(new StreamHandler("{$this->logPath}/request.log"));
        $this->loggers['request']->info("REQUEST", $data);
    }
}
