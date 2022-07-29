<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Serializer\SerializerInterface;

use App\Entity\Bill;
use App\Repository\BillRepository;
use Symfony\Component\Serializer\Encoder\EncoderInterface;

use Doctrine\ORM\EntityManagerInterface;


class TestSerializerController extends AbstractController
{
    public function __construct(
        private BillRepository $billRepo,
    ) {}

    #[Route('/test/serializer', name: 'app_test_serializer')]
    public function index(
        SerializerInterface $serializer, 
        EncoderInterface $encoder ,
        EntityManagerInterface $entityManager
         ): Response
    {

        /**
         * création d'un object de type Bill
         * on prend une facture au hasard (1)
         * on la sérialize en json
         * dans le nouvel object de type Bill, on affecte lui affecte la facture sérialié dans la propriété copy
         * ensuite la facture prend en valeur de copy le nouvel object
         * on persist puis flush 1 FOIS seulement sinon perte de la donnée
         */
        $newBill = new Bill() ;
        $bill = $this->billRepo->find(1);
        $jsonBill = $serializer->serialize($bill , 'json');

        $newBill->setBillCopy($jsonBill);

        // $encodedJsonBill = $encoder->encode($jsonBill , 'json');
        $bill->setBillCopy($newBill->getBillCopy());
        dump($bill);

        // $entityManager->persist($bill);
        // $entityManager->flush();


        return $this->render('test_serializer/index.html.twig', [
            'controller_name' => 'TestSerializerController',
            'a' => $jsonBill,
            // 'b' => $bill->getBillCopy()
        ]); 
    }
}
