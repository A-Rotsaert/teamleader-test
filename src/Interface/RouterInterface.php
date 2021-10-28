<?php

declare(strict_types=1);

namespace App\Interface;

/**
 * RouterInterface
 *
 * @author <andy.rotsaert@live.be>
 */
interface RouterInterface
{
    /**
     * Ensure future compatibility if we decide to change the router.
     */
    public function initialize(): void;
}
