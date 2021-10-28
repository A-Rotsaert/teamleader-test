<?php

declare(strict_types=1);

namespace App\Config;

/**
 * @author <andy.rotsaert@live.be>
 */
interface ConfigInterface
{
    /**
     * @param string $type
     * @param string $configKey
     *
     * @return mixed
     */
    public function get(string $type, string $configKey): mixed;
}
