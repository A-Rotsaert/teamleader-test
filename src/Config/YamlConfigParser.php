<?php

declare(strict_types=1);

namespace App\Config;

use App\Logger\LoggerInterface;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

/**
 * YamlConfigParser
 *
 * @author <andy.rotsaert@live.be>
 */
final class YamlConfigParser implements ConfigInterface
{
    /**
     * @var string
     */
    private string $configDirectory;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * Constructor
     *
     * Sets the config directory from where to load the individual config files.
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->configDirectory = dirname($_SERVER['DOCUMENT_ROOT']) . $_ENV['CONFIG_PATH'];
    }

    /**
     * @param string $type
     * @param string|null $configKey
     *
     * @return mixed
     */
    public function get(string $type, ?string $configKey = null): mixed
    {
        $config = $this->parseConfig($this->getConfig($type), $type);

        return ($configKey) ? $this->traverseConfig($config, $configKey, $type) : $config;
    }

    /**
     * @param array $arr
     * @param string $path
     * @param string $type
     *
     * @return mixed
     */
    private function traverseConfig(array $arr, string $path, string $type): mixed
    {
        $pointer = $arr;
        $keys = explode('.', $path);

        foreach ($keys as $key) {
            if (isset($pointer[$key])) {
                $pointer = $pointer[$key];
            } else {
                $errorMessage = "Unable to find key '{$pointer}' from '{$path}' in  {$type}.yaml";
                $this->logger->critical($errorMessage);
                throw new \InvalidArgumentException($errorMessage);
            }
        }

        return $pointer;
    }

    /**
     * @param string $config
     * @param $type
     *
     * @return array|null
     */
    private function parseConfig(string $config, $type): ?array
    {
        try {
            return Yaml::parse($config);
        } catch (ParseException $exception) {
            // changing the message to provide more info over the default ParseException message
            throw new ParseException(
                sprintf('Unable to parse the %s.yaml config: %s', $type, $exception->getMessage())
            );
        }
    }

    /**
     * @param string $type
     *
     * @return string
     */
    private function getConfig(string $type): string
    {
        $file = sprintf('%s/%s.yaml', $this->configDirectory, $type);
        if (file_exists($file)) {
            return file_get_contents($file);
        } else {
            throw new \InvalidArgumentException(sprintf('YamlConfigParser file "%s" does not exist', $file));
        }
    }
}
