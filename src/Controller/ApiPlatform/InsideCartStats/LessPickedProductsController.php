<?php

namespace App\Controller\ApiPlatform\InsideCartStats;

use App\Repository\InsideShoppingCartRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class LessPickedProductsController extends AbstractController
{

    public function __construct(
        private InsideShoppingCartRepository $insideShoppingCartRepository,
    )
    {}

    public function __invoke(
    ) 
    {
        return $this->insideShoppingCartRepository->getMostPickedProduct(5 , 'ASC');
    }

}
