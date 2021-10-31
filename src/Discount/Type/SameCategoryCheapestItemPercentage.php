<?php

declare(strict_types=1);

namespace App\Discount\Type;

/**
 * SameCategoryCheapestItemPercentage
 *
 * @author <andy.rotsaert@live.be>
 */
final class SameCategoryCheapestItemPercentage extends AbstractDiscountType
{
    /**
     * @param array $order
     * @param array $discountSettings
     * @return mixed|void
     */
    public function processOrder(array &$order, array $discountSettings)
    {
        if ($cheapestItem = $this->getCheapestItemForCategory($order, $discountSettings)) {
            $this->calculateDiscountOnCheapestItem($cheapestItem, $order, $discountSettings);
        }
    }

    /**
     * @param array $order
     * @param array $discountSettings
     * @return array
     */
    private function getCheapestItemForCategory(array $order, array $discountSettings): array
    {
        $cheapestItem = null;
        foreach ($order['items'] as $item) {
            $product = $this->getProduct($item['product-id']);
            if ((int)$product['category'] === $discountSettings['discount']['category']) {
                if (!$cheapestItem) {
                    $cheapestItem = $product;
                } elseif ($cheapestItem['price'] > $item['unit-price']) {
                    $cheapestItem = $product;
                }
            }
        }
        return $cheapestItem;
    }

    /**
     * @param array $cheapestItem
     * @param array $order
     * @param $discountSettings
     */
    private function calculateDiscountOnCheapestItem(array $cheapestItem, array &$order, $discountSettings)
    {
        $discount = $this->calulateDiscountFromPercentage(
            $cheapestItem['price'],
            $discountSettings['discount']['percentage']
        );
        $order['total'] -= $discount;
        $order['discounts']['items'][$cheapestItem['id']] = "-{$discount}";
        $order['discounts']['reasons'][] = sprintf(
            $discountSettings['reason'],
            $discountSettings['discount']['percentage'],
            $discountSettings['discount']['category']
        );
    }
}
