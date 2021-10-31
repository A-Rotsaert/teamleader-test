<?php

declare(strict_types=1);

namespace App\Discount\Type;

use App\Discount\Interface\DiscountInterface;
use App\Interface\RepositoryInterface;

/**
 * AbstractDiscountType
 *
 * @author <andy.rotsaert@live.be>
 */
abstract class AbstractDiscountType implements DiscountInterface
{
    /**
     * @var RepositoryInterface
     */
    protected RepositoryInterface $repository;

    /**
     * @param RepositoryInterface $repository
     */
    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $orderProducts
     * @return bool
     */
    public function checkProducts(array $orderProducts): bool
    {
        foreach ($orderProducts as $p) {
            if (!$this->getProduct($p['product-id'])) {
                throw new \InvalidArgumentException("Product with product id {$p['product-id']} does not exist");
            }
        }

        return true;
    }

    /**
     * @param string $id
     * @return array
     */
    public function getProduct(string $id): array
    {
        $product = $this->repository->getManager('products')->find($id);
        if (!$product) {
            throw new \InvalidArgumentException("Product with product id {$id} does not exist");
        }

        return $product;
    }

    /**
     * @param $total
     * @param $percentage
     * @return float
     */
    public function calulateDiscountFromPercentage($total, $percentage): float
    {
        return ($total / 100) * $percentage;
    }
}
