<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Serializer\SerializerInterface;

use App\Entity\User;
use App\Repository\UserRepository;

use Symfony\Component\Serializer\Encoder\EncoderInterface;
use Symfony\Component\Serializer\Encoder\DecoderInterface;



class TestSerializerController extends AbstractController
{
    public function __construct(
        private UserRepository $userRepo
    ) {}

    #[Route('/test/serializer', name: 'app_test_serializer')]
    public function index(
        SerializerInterface $serializer, 
        EncoderInterface $encoder ,
        DecoderInterface $decoder
         ): Response
    {

        $user = $this->userRepo->find(1);
        $jsonUser = $serializer->serialize($user , 'json');
        $encodedJsonUser = $encoder->encode($jsonUser , 'json');
        dump($encodedJsonUser);

        $newUser = new User();
        


        return $this->render('test_serializer/index.html.twig', [
            'controller_name' => 'TestSerializerController'
        ]);
    }
}
