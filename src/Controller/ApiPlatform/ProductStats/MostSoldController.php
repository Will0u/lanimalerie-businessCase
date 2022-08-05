<?php

namespace App\Controller\ApiPlatform\ProductStats;

use App\Repository\InsideShoppingCartRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class MostSoldController extends AbstractController
{

    public function __construct(
        private InsideShoppingCartRepository $insideShoppingCartRepository,
    )
    {}

    public function __invoke(
    ) 
    {
        return $this->insideShoppingCartRepository->getMostSoldProducts(5 , 'desc');
    }

}
