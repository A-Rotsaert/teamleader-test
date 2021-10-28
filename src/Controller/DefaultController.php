<?php

declare(strict_types=1);

namespace App\Controller;

use App\Router\Response;

/**
 * DefaultController
 *
 * @todo build a better front page.
 * @author <andy.rotsaert@live.be>
 */
final class DefaultController extends AbstractController
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        $this->getLogger()->info('index loaded');
        $invalidArgument = [
            'id' => 1,
            'invalid' => 'invalid argument',
        ];
        $this->doesntwork($invalidArgument);

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
