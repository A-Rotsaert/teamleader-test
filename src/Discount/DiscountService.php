<?php

declare(strict_types=1);

namespace App\Discount;

use App\Discount\Interface\DiscountInterface;
use App\Discount\Locator\DiscountLocator;
use App\Interface\ConfigInterface;
use App\Interface\RepositoryInterface;

/**
 * DiscountService
 *
 * @author <andy.rotsaert@live.be>
 */
final class DiscountService
{
    /**
     * @var RepositoryInterface
     */
    private RepositoryInterface $repository;

    /**
     * @var DiscountLocator
     */
    private DiscountLocator $discountLocator;

    /**
     * @param ConfigInterface $config
     * @param RepositoryInterface $repository
     * @param DiscountLocator $discountLocator
     */
    public function __construct(
        ConfigInterface $config,
        RepositoryInterface $repository,
        DiscountLocator $discountLocator,
    ) {
        $this->repository = $repository->getManager('discounts');
        $this->discountLocator = $discountLocator;

        if ($config->get('discount', 'service_enabled')) {
            $this->getActiveDiscounts();
        }
    }

    /**
     * @return array
     */
    private function getActiveDiscounts(): array
    {
        return $this->repository->findBy(['active' => true]);
    }

    /**
     * @param array $order
     * @return array
     */
    public function processOrder(array $order): array
    {
        foreach ($this->getActiveDiscounts() as $discountSettings) {
            $discountType = $this->getDiscountFromType($discountSettings['type']);
            $discountType->processOrder($order, $discountSettings);
        }

        return $order;
    }

    /**
     * @param string $type
     * @return DiscountInterface
     */
    private function getDiscountFromType(string $type): DiscountInterface
    {
        return $this->discountLocator->locate($type);
    }
}
