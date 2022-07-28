<?php

namespace App\Entity;

use App\Repository\InsideShoppingCartRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: InsideShoppingCartRepository::class)]
#[ApiResource(
    attributes: ["security" => "is_granted('ROLE_STAT')"],
    collectionOperations: [
        "get",
        "post" => [
            "security" => "is_granted('ROLE_ADMIN')"
        ]
    ],
    itemOperations: [
        "get",
        "put" => [
            "security" => "is_granted('ROLE_ADMIN')"
        ],
        "delete" => [
            "security" => "is_granted('ROLE_ADMIN')"
        ],
        "patch" => [
            "security" => "is_granted('ROLE_ADMIN')"
        ]
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
        message : '{{ label }} ne peut pas être vide.'
    )]
    private ?int $quantity = null;

    #[ORM\ManyToOne(inversedBy: 'insideShoppingCarts')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(
        message : '{{ label }} ne peut pas être vide.'
    )]
    private ?Product $product = null;

    #[ORM\ManyToOne(inversedBy: 'insideShoppingCarts')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(
        message : '{{ label }} ne peut pas être vide.'
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
