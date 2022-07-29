<?php

namespace App\Entity;

use App\Repository\BillRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BillRepository::class)]
#[ApiResource(
    normalizationContext : [
       'groups' => ['bill']
       ] ,
    attributes: [
        "security" => "is_granted('ROLE_ADMIN')",
        "security_message" => "Accès refusé.",
    ],
    collectionOperations: [
        "get" => [
            "security" => "is_granted('ROLE_STATS')",
        ],
    ],
    itemOperations: [
        "get" => [
            "security" => "is_granted('ROLE_STATS')"
        ],
    ],
)]
class Bill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank(
        message : 'La date de paiement ne peut pas être vide.'
    )]
    #[Assert\LessThan('now')]
    #[Groups("bill")]
    private ?\DateTimeInterface $paidAt = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(
        message : 'La copie de la facture ne peut pas être vide.'
    )]
    #[Groups("bill")]
    private ?string $billCopy = null;

    #[ORM\ManyToOne(inversedBy: 'bills')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(
        message : 'Le panier ne peut pas être vide.'
    )]
    #[Groups("bill")]
    private ?ShoppingCart $shoppingCart = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPaidAt(): ?\DateTimeInterface
    {
        return $this->paidAt;
    }

    public function setPaidAt(\DateTimeInterface $paidAt): self
    {
        $this->paidAt = $paidAt;

        return $this;
    }

    public function getBillCopy(): ?string
    {
        return $this->billCopy;
    }

    public function setBillCopy(string $billCopy): self
    {
        $this->billCopy = $billCopy;

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
