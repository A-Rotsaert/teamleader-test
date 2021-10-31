<?php

declare(strict_types=1);

namespace App\Config;

use App\Discount\Locator\DiscountLocator;
use App\Interface\ConfigInterface;
use App\Interface\DebugInterface;
use App\Interface\LoggerInterface;
use App\Interface\RepositoryInterface;
use App\Interface\RouterInterface;
use App\Logger\Logger;
use App\Repository\JsonRepository;
use App\Router\Router;
use App\Service\DebugService;

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
     * Configure container and autowire
     *
     * @return array
     */
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
            RepositoryInterface::class => function (ConfigInterface $config) {
                return new JsonRepository($config);
            },
            DiscountLocator::class => function (ConfigInterface $config, RepositoryInterface $repository) {
                return new DiscountLocator($config, $repository);
            }
        ];
    }
}
