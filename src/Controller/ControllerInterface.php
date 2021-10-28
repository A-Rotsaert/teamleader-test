<?php

declare(strict_types=1);

namespace App\Controller;

use App\Router\Response;

/**
 * ControllerInterface
 *
 * @author <andy.rotsaert@live.be>
 */
interface ControllerInterface
{
    /**
     * Force at least an index (for routing) per controller
     *
     * @return Response
     */
    public function index(): Response;
}
