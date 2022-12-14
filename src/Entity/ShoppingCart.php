<?php

namespace App\Entity;

use App\Repository\ShoppingCartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\ApiPlatform\CartStats\AverageMoneyController;
use App\Controller\ApiPlatform\CartStats\TotalCartsController;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ShoppingCartRepository::class)]
#[ApiResource(
    normalizationContext : [
        'groups' => ['cart']
        ] ,
    attributes: [
        "security" => "is_granted('ROLE_ADMIN')",
        "security_message" => "Accès refusé."
    ],
    collectionOperations: [
        "get" => [
            "security" => "is_granted('ROLE_STATS')"
        ],

        'stats' => [
            "security" => "is_granted('ROLE_STATS')",
            'method' => 'GET',
            'path' => '/shopping_carts/stats',
            'controller' => TotalCartsController::class
        ],

        'average' => [
            "security" => "is_granted('ROLE_STATS')",
            'method' => 'GET',
            'path' => '/shopping_carts/average',
            'controller' => AverageMoneyController::class
        ]

    ],
    itemOperations: [
        "get" => [
            "security" => "is_granted('ROLE_STATS')"
        ],
    ],
)]
class ShoppingCart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank(
        message : 'La date de création ne peut pas être vide.'
    )]
    #[Assert\LessThan('now')]
    #[Groups(['bill' , 'cart'])]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'shoppingCart')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(
        message : 'L\'id de l\'utlisateur ne peut pas être vide.'
    )]
    #[Groups(['bill' , 'cart'])]
    private ?User $user = null;


    #[ORM\ManyToOne(inversedBy: 'shoppingCarts')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(
        message : 'L\'id du status ne peut pas être vide.'
    )]
    #[Groups(['bill' , 'cart'])]
    private ?Status $status = null;

    #[ORM\ManyToOne(inversedBy: 'shoppingCarts')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(
        message : 'L\'id du paiement ne peut pas être vide.'
    )]
    #[Groups(['bill' , 'cart'])]
    private ?Payment $payment = null;

    #[ORM\OneToMany(mappedBy: 'shoppingCart', targetEntity: InsideShoppingCart::class)]
    #[Groups(['bill' , 'cart'])]
    private Collection $insideShoppingCarts;

    #[ORM\OneToMany(mappedBy: 'shoppingCart', targetEntity: Bill::class)]
    private Collection $bills;

    public function __construct()
    {
        $this->insideShoppingCarts = new ArrayCollection();
        $this->bills = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPayment(): ?Payment
    {
        return $this->payment;
    }

    public function setPayment(?Payment $payment): self
    {
        $this->payment = $payment;

        return $this;
    }

    /**
     * @return Collection<int, InsideShoppingCart>
     */
    public function getInsideShoppingCarts(): Collection
    {
        return $this->insideShoppingCarts;
    }

    public function addInsideShoppingCart(InsideShoppingCart $insideShoppingCart): self
    {
        if (!$this->insideShoppingCarts->contains($insideShoppingCart)) {
            $this->insideShoppingCarts->add($insideShoppingCart);
            $insideShoppingCart->setShoppingCart($this);
        }

        return $this;
    }

    public function removeInsideShoppingCart(InsideShoppingCart $insideShoppingCart): self
    {
        if ($this->insideShoppingCarts->removeElement($insideShoppingCart)) {
            // set the owning side to null (unless already changed)
            if ($insideShoppingCart->getShoppingCart() === $this) {
                $insideShoppingCart->setShoppingCart(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Bill>
     */
    public function getBills(): Collection
    {
        return $this->bills;
    }

    public function addBill(Bill $bill): self
    {
        if (!$this->bills->contains($bill)) {
            $this->bills->add($bill);
            $bill->setShoppingCart($this);
        }

        return $this;
    }

    public function removeBill(Bill $bill): self
    {
        if ($this->bills->removeElement($bill)) {
            // set the owning side to null (unless already changed)
            if ($bill->getShoppingCart() === $this) {
                $bill->setShoppingCart(null);
            }
        }

        return $this;
    }
}
