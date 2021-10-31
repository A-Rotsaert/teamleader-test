<?php

declare(strict_types=1);

namespace App\Trait;

/**
 * BadMethodCallTrait
 *
 * @author <andy.rotsaert@live.be>
 */
trait BadMethodCallTrait
{
    /**
     * @param string $name
     * @param array $arguments
     */
    public function __call(string $name, array $arguments): void
    {
        throw new \BadMethodCallException("Method {$name} does not exist in {$this->getClass()}.");
    }

    /**
     * Get class that uses the trait
     *
     * @return string
     */
    public static function getClass(): string
    {
        return static::class;
    }
}
