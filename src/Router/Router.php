<?php

declare(strict_types=1);

namespace App\Router;

use App\App;
use App\Interface\ConfigInterface;
use App\Interface\RouterInterface;
use DI\Container;

/**
 * Router
 *
 * @author <andy.rotsaert@live.be>
 */
final class Router implements RouterInterface
{
    /**
     * @var array
     */
    private array $routes;

    /**
     * @var Container
     */
    private Container $container;

    /**
     * @param ConfigInterface $config
     */
    public function __construct(ConfigInterface $config)
    {
        $this->routes = $config->get('routes');
        $this->container = App::getContainer();
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function initialize(): void
    {
        if ($this->doChecks($route = $this->getRouteFromUri())) {
            $this->container->call($route['fully_qualified_name']);
        }
    }

    /**
     * Make sure we get a valid route that directs us to a valid controller method
     *
     * @param array|bool $route
     *
     * @return bool|\Exception
     */
    private function doChecks(array|bool $route): bool|\Exception
    {
        if (!$route) {
            throw new \InvalidArgumentException(
                "Route {$_SERVER['REQUEST_URI']} does not exists."
            );
        }
        $explodedFullyQualifiedName = explode('::', $route['fully_qualified_name']);

        if (!$route = $this->getRouteFromUri()) {
            throw new \InvalidArgumentException(
                "Route {$_SERVER['REQUEST_URI']} does not exists."
            );
        } elseif (!in_array($_SERVER['REQUEST_METHOD'], $route['accepts'])) {
            throw new \InvalidArgumentException(
                "Route {$_SERVER['REQUEST_URI']} does not accept HTTP method {$_SERVER['REQUEST_METHOD']}"
            );
        } elseif (!class_exists($explodedFullyQualifiedName[0])) {
            throw new \LogicException(
                "Class extracted from fully qualified name(FQN) does not exist."
            );
        } elseif (!method_exists($explodedFullyQualifiedName[0], $explodedFullyQualifiedName[1])) {
            throw new \LogicException(
                "Class {$explodedFullyQualifiedName[0]} doesn't have method {$explodedFullyQualifiedName[1]}."
            );
        }

        return true;
    }

    /**
     * Get Route
     * Tries to match the current uri to a defined route, returns false if no route was found.
     *
     * @return false|array
     */
    private function getRouteFromUri(): false|array
    {
        $routesArrayValues = array_values($this->routes);
        $routeArrayIndex = (array_search($_SERVER['REQUEST_URI'], array_column($routesArrayValues, 'uri')));

        return (is_int($routeArrayIndex)) ? $routesArrayValues[$routeArrayIndex] : $routeArrayIndex;
    }
}
