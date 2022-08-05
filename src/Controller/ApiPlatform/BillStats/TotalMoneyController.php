<?php

namespace App\Controller\ApiPlatform\BillStats;

use App\Repository\BillRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class TotalMoneyController extends AbstractController
{

    public function __construct(
        private BillRepository $billRepository,
    )
    {}

    public function __invoke(
    ) 
    {
        return $this->billRepository->getTotalMoney();
    }

}
