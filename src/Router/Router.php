<?php

declare(strict_types=1);

namespace App\Router;

use App\App;
use App\Config\ConfigInterface;
use DI\Container;

/**
 * Router
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
     * Get Route
     *
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
     * @param array $route
     *
     * @return bool|\Exception
     */
    private function doChecks(array $route): bool|\Exception
    {
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
}
