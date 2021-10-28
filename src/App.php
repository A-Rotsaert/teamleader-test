<?php

declare(strict_types=1);

namespace App;

use App\Config\ContainerConfig;
use App\Interface\DebugInterface;
use App\Interface\RouterInterface;
use DI\Container;
use DI\ContainerBuilder;
use Dotenv\Dotenv;

/**
 * App
 * @author <andy.rotsaert@live.be>
 */
final class App
{
    /**
     * @var App|null
     */
    private static ?App $instance = null;

    /**
     * @var Container
     */
    private static Container $container;


    /**
     *  Bootstrap application
     *
     *  -   Load .env variables in the global environment $_ENV
     *  -   Get service definitions
     *  -   Build the container and add the service definitions
     *  -   Initialize Router
     *
     * @throws \Exception
     */
    private function __construct()
    {
        $dotenv = Dotenv::createImmutable(dirname($_SERVER['DOCUMENT_ROOT']));
        $dotenv->safeLoad();

        $definitions = ContainerConfig::getServices();
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->addDefinitions($definitions);
        self::$container = $containerBuilder->build();
        self::$container->make(DebugInterface::class);
        self::$container->make(RouterInterface::class);
    }

    /**
     * @return App|null
     */
    public static function createInstance(): ?App
    {
        if (!self::$instance instanceof App) {
            self::$instance = new App();
        }

        return self::$instance;
    }

    /**
     * @return Container
     */
    public static function getContainer(): Container
    {
        return self::$container;
    }
}
