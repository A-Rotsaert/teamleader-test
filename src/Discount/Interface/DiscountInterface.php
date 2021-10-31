<?php

declare(strict_types=1);

namespace App\Discount\Interface;

/**
 * DiscountTypeInterface
 *
 * @author <andy.rotsaert@live.be>
 */
interface DiscountInterface
{
    /**
     * @param array $order
     * @param array $discountSettings
     * @return mixed
     */
    public function processOrder(array &$order, array $discountSettings);
}
