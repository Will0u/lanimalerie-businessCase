<?php

namespace App\Entity;

use App\Repository\BillRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BillRepository::class)]
class Bill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $paidAt = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $billCopy = null;

    #[ORM\ManyToOne(inversedBy: 'bills')]
    #[ORM\JoinColumn(nullable: false)]
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
