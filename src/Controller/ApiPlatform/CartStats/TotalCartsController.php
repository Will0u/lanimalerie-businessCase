<?php

namespace App\Controller\ApiPlatform\CartStats;

use App\Repository\ShoppingCartRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class TotalCartsController extends AbstractController
{

    public function __construct(
        private ShoppingCartRepository $cartRepo,
    )
    {}

    public function __invoke(
    ) 
    {
        return [
            $this->cartRepo->getAllCarts(),
            $this->cartRepo->getValidatesCart(),
            $this->cartRepo->getFailedCarts(),
            $this->cartRepo->getStandByValidationCarts(),
            $this->cartRepo->getAbortedCarts(),
            $this->cartRepo->getStandByPaymentCarts(),
        ];
    }

}
