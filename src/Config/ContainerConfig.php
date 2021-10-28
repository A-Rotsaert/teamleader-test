<?php

declare(strict_types=1);

namespace App\Config;

use App\Interface\ConfigInterface;
use App\Interface\DebugInterface;
use App\Interface\LoggerInterface;
use App\Interface\RouterInterface;
use App\Logger\Logger;
use App\Router\Router;
use App\Service\DebugService;
use JetBrains\PhpStorm\ArrayShape;

use function DI\get;

/**
 * ContainerConfig
 *
 * @todo Fetch this data from config/services.yaml
 * @author <andy.rotsaert@live.be>
 */
class ContainerConfig
{
    /**
     * @return array
     */
    #[ArrayShape([
        RouterInterface::class => "\Closure",
        LoggerInterface::class => "\Closure",
        DebugInterface::class => "\DI\Definition\Reference",
        ConfigInterface::class => "\DI\Definition\Reference",
    ])]
    public static function getServices(): array
    {
        return [
            RouterInterface::class => function (ConfigInterface $config) {
                $router = new Router($config);
                $router->initialize();

                return $router;
            },
            LoggerInterface::class => function () {
                $logger = new Logger();
                $logger->enableSystemLogs();

                return $logger;
            },
            DebugInterface::class => get(DebugService::class),
            ConfigInterface::class => get(YamlConfigParser::class),
        ];
    }
}
