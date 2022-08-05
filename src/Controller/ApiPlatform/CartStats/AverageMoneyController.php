<?php

namespace App\Controller\ApiPlatform\CartStats;

use App\Repository\ShoppingCartRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AverageMoneyController extends AbstractController
{

    public function __construct(
        private ShoppingCartRepository $cartRepo,
    )
    {}

    public function __invoke(
    ) 
    {
        return $this->cartRepo->getAverageMoney();
    }

}
