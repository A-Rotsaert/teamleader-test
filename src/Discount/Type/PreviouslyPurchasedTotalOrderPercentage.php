<?php

declare(strict_types=1);

namespace App\Discount\Type;

/**
 * AboveTotalOrderPercentage
 *
 * @author <andy.rotsaert@live.be>
 */
final class PreviouslyPurchasedTotalOrderPercentage extends AbstractDiscountType
{
    /**
     * @param array $order
     * @param array $discountSettings
     * @return void
     */
    public function processOrder(array &$order, array $discountSettings): void
    {
        $customerRepository = $this->repository->getManager('customers');
        $customer = $customerRepository->findBy(['id' => $order['customer-id']])[0];

        $previouslyPurchasedSum = $customer['revenue'];
        if ($previouslyPurchasedSum > $discountSettings['discount']['total']) {
            $discount = $this->calulateDiscountFromPercentage(
                $order['total'],
                $discountSettings['discount']['percentage']
            );
            $order['total'] -= $discount;
            $order['discounts']['reasons'][] = $discountSettings['reason'];
        }
    }
}
