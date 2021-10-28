<?php

declare(strict_types=1);

namespace App\Service;

use App\Interface\ConfigInterface;
use App\Interface\DebugInterface;
use JetBrains\PhpStorm\ArrayShape;
use Kint;
use Kint\Renderer\RichRenderer;

/**
 * DebugService
 *
 * @author <andy.rotsaert@live.be>
 */
final class DebugService implements DebugInterface
{
    /**
     * Setup Kint on development (or any other) environments, unless overridden in debug.yaml
     * On production, make sure we disabled it.
     */
    public function __construct(ConfigInterface $config)
    {
        $config = $this->getConfig($config);
        switch ($_ENV['APP_ENV']) {
            default:
            case "dev":
                RichRenderer::$folder = $config['expanded'];
                RichRenderer::$theme = $config['theme'];
                Kint::$enabled_mode = $config['enabled'];
                break;
            case "production":
                Kint::$enabled_mode = false;
                break;
        }
    }

    /**
     * @param ConfigInterface $config
     *
     * @return array
     */
    #[
        ArrayShape([
            "enabled" => "bool",
            "expanded" => "bool",
            "theme" => "string",
        ])]
    private function getConfig(ConfigInterface $config): array
    {
        return [
            'enabled' => $config->get('debug', 'enabled'),
            'expanded' => (!$config->get('debug', 'expanded')),
            'theme' => sprintf(
                '%s/kint-php/kint/resources/compiled/%s',
                VENDOR_PATH,
                $config->get('debug', 'theme')
            ),
        ];
    }
}
