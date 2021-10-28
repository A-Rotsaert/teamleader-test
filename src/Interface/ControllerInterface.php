<?php

declare(strict_types=1);

namespace App\Interface;

/**
 * ControllerInterface
 *
 * @author <andy.rotsaert@live.be>
 */
interface ControllerInterface
{
    /**
     * @return LoggerInterface
     */
    public function getLogger(): LoggerInterface;
}
