<?php

declare(strict_types=1);

namespace App\Controller;

use App\Logger\LoggerInterface;

/**
 * AbstractController
 * Used to provide the controller with basic utilities
 *
 * @author <andy.rotsaert@live.be>
 */
abstract class AbstractController implements ControllerInterface
{
    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
