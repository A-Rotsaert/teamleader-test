<?php

declare(strict_types=1);

namespace App\Discount\Locator;

use App\Discount\Interface\DiscountInterface;
use App\Interface\ConfigInterface;
use App\Interface\RepositoryInterface;

/**
 * DiscountLocator
 *
 * @author <andy.rotsaert@live.be>
 */
final class DiscountLocator
{
    /**
     * @var ConfigInterface
     */
    private ConfigInterface $config;

    /**
     * @var RepositoryInterface
     */
    private RepositoryInterface $repository;

    /**
     * @param ConfigInterface $config
     * @param RepositoryInterface $repository
     */
    public function __construct(ConfigInterface $config, RepositoryInterface $repository)
    {
        $this->config = $config;
        $this->repository = $repository;
    }

    /**
     * @param string $type
     * @return DiscountInterface
     */
    public function locate(string $type): DiscountInterface
    {
        return $this->getClassFromType($type);
    }

    /**
     * @param string $type
     * @return mixed
     */
    private function getClassFromType(string $type)
    {
        $discountTypes = $this->config->get('discount', "types");
        $discountClassFQName = array_column($discountTypes, $type)[0];
        if (!class_exists($discountClassFQName)) {
            throw new \LogicException(
                "Class with name {$discountClassFQName} (FQN) does not exist."
            );
        }

        return new $discountClassFQName($this->repository);
    }
}
