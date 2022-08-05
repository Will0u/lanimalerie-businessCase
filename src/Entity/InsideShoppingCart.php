<?php

namespace App\Entity;

use App\Repository\InsideShoppingCartRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\ApiPlatform\InsideCartStats\LessPickedProductsController;
use App\Controller\ApiPlatform\InsideCartStats\MostPickedProductsController;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: InsideShoppingCartRepository::class)]
#[ApiResource(
    normalizationContext : [
        'groups' => ['insideCart']
        ] ,
    attributes: [
        "security" => "is_granted('ROLE_ADMIN')",
        "security_message" => "Accès refusé."
    ],
    collectionOperations: [
        "get" => [
            "security" => "is_granted('ROLE_STATS')"
        ],
        'mostPickedProducts' => [
            "security" => "is_granted('ROLE_STATS')",
            'method' => 'GET',
            'path' => '/inside_shopping_carts/most_picked_products',
            'controller' => MostPickedProductsController::class
        ],

        'lessPickedProducts' => [
            "security" => "is_granted('ROLE_STATS')",
            'method' => 'GET',
            'path' => '/inside_shopping_carts/less_picked_products',
            'controller' => LessPickedProductsController::class
        ]
    ],
    itemOperations: [
        "get" => [
            "security" => "is_granted('ROLE_STATS')"
        ],
    ],
)]
class InsideShoppingCart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank(
        message : 'La quantité ne peut pas être vide.'
    )]
    #[Groups(["bill" , "insideCart"])]
    private ?int $quantity = null;

    #[ORM\ManyToOne(inversedBy: 'insideShoppingCarts')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(
        message : 'Le produit ne peut pas être vide.'
    )]
    #[Groups(["bill" , "insideCart", "cart"])]
    private ?Product $product = null;

    #[ORM\ManyToOne(inversedBy: 'insideShoppingCarts')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(
        message : 'Le panier ne peut pas être vide.'
    )]
    private ?ShoppingCart $shoppingCart = null;


    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getShoppingCart(): ?ShoppingCart
    {
        return $this->shoppingCart;
    }

    public function setShoppingCart(?ShoppingCart $shoppingCart): self
    {
        $this->shoppingCart = $shoppingCart;

        return $this;
    }


}
