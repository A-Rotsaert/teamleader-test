<?php

declare(strict_types=1);

namespace App\Controller;

use App\Interface\ControllerInterface;
use App\Interface\DebugInterface;
use App\Interface\LoggerInterface;
use App\Trait\BadMethodCallTrait;
use JetBrains\PhpStorm\NoReturn;

/**
 * AbstractController
 * Used to provide the controller with basic utilities.
 * Also catches methods being invoked that are inaccessible with the BadMethodCallTrait.
 *
 * @author <andy.rotsaert@live.be>
 */
abstract class AbstractController implements ControllerInterface
{
    use BadMethodCallTrait;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var DebugInterface
     */
    private DebugInterface $debugger;

    /**
     * @param LoggerInterface $logger
     */
    #[NoReturn]
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }
}
