<?php

namespace App\Controller\ApiPlatform\UserStats;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class TotalUsersController extends AbstractController
{

    public function __construct(
        private UserRepository $useRepo,
    )
    {}

    public function __invoke(
    ) 
    {
        return $this->useRepo->getAllUsers();
    }

}
