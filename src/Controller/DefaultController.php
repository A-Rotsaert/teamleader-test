<?php

declare(strict_types=1);

namespace App\Controller;

use App\Router\Request;
use App\Router\Response;
use Parsedown;

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
        $contents = file_get_contents(ROOT_PATH . 'README.md');
        $parsedown = new Parsedown();
        return new Response(200, $parsedown->text($contents), 'html-md');
    }

    /**
     * @return Response
     */
    public function test(): Response
    {
        $this->getLogger()->info('test loaded, this does not do much. :)');
        $invalidArgument = [
            'id' => 1,
            'invalid' => 'invalid argument',
        ];
        $this->doesntwork($invalidArgument);

        return new Response(400, 'Test OK? Well not if we call a method that does not exist.');
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function markdown(Request $request): Response
    {
        $contents = file_get_contents(ROOT_PATH . $request->get());
        $parsedown = new Parsedown();
        return new Response(200, $parsedown->text($contents), 'html-md');
    }
}
