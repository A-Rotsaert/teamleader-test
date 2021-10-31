<?php

declare(strict_types=1);

namespace App\Discount\Type;

/**
 * BuyXGetYFromSameCategory
 *
 * @author <andy.rotsaert@live.be>
 */
final class BuyXGetYFromSameCategory extends AbstractDiscountType
{
    /**
     * @param array $order
     * @param array $discountSettings
     * @return void
     */
    public function processOrder(array &$order, array $discountSettings): void
    {
        if ($this->checkProducts($order['items'])) {
            foreach ($order['items'] as $key => $item) {
                $product = $this->getProduct($item['product-id']);
                if ((int)$product['category'] === $discountSettings['discount']['category']) {
                    if ($item['quantity'] >= $discountSettings['discount']['quantity']) {
                        $applyTimes = ($order['items'][$key]['quantity'] / $discountSettings['discount']['quantity']);
                        for ($i = 0; $i < $applyTimes; $i++) {
                            $order['items'][$key]['quantity'] += $discountSettings['discount']['free_items'];
                        }
                        $order['discounts']['reasons'][] = sprintf(
                            "%s from category %s, discount applied %d times",
                            $discountSettings['reason'],
                            $discountSettings['discount']['category'],
                            $applyTimes
                        );
                    }
                }
            }
        }
    }
}
