<?php

declare(strict_types=1);

namespace App\Controller;

use App\Discount\DiscountService;
use App\Interface\LoggerInterface;
use App\Router\Request;
use App\Router\Response;

/**
 * OrderController
 *
 * @author <andy.rotsaert@live.be>
 */
final class OrderController extends AbstractController
{
    private DiscountService $discounts;

    /**
     * @param DiscountService $discounts
     * @param LoggerInterface $logger
     */
    public function __construct(
        DiscountService $discounts,
        LoggerInterface $logger,
    ) {
        $this->discounts = $discounts;
        parent::__construct($logger);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        return new Response(200, $this->discounts->processOrder($request->post()));
    }
}
