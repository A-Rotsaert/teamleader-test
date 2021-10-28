<?php

declare(strict_types=1);

namespace App\Controller;

use App\Router\Response;

/**
 * DefaultController
 *
 * @author <andy.rotsaert@live.be>
 */
final class DefaultController extends AbstractController
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        $this->logger->info('index loaded');

        return new Response(200, 'Index loaded OK');
    }

    /**
     * @return Response
     */
    public function test(): Response
    {
        return new Response(201, ['id' => 1, 'name' => 'test']);
    }
}
