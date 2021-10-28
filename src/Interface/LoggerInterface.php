<?php

declare(strict_types=1);

namespace App\Interface;

/**
 * LoggerInterface
 *
 * @author <andy.rotsaert@live.be>
 */
interface LoggerInterface
{
    /**
     * Ensures future compatibility if we decide to switch logger library
     *
     * @return void
     */
    public function enableSystemLogs(): void;
}
