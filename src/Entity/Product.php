<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource(
    attributes: [
        "security" => "is_granted('ROLE_ADMIN')",
        "security_message" => "Accès refusé."
    ],
    collectionOperations: [
        "get" => [
            "security" => "is_granted('ROLE_STATS')"
        ],
        "post"
    ],
    itemOperations: [
        "get" => [
            "security" => "is_granted('ROLE_STATS')"
        ],
        "put",
        "delete",
        "patch"
    ],
)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'L\'URL de l\'image doit faire plus de {{ limit }} caractères.',
        maxMessage: 'L\'URL de l\'image doit faire moins de {{ limit }} caractères.',
    )]
    private ?string $imageUrl = null;

    #[ORM\Column(length: 80)]
    #[Assert\Length(
        min: 2,
        max: 80,
        minMessage: 'Le nom du produit doit faire plus de {{ limit }} caractères.',
        maxMessage: 'Le nom du produit doit faire moins de {{ limit }} caractères.',
    )]
    private ?string $name = null;

    #[ORM\Column]
    #[Assert\Range(
        min: 0,
        max: 1,
        notInRangeMessage: 'Doit être un booléen : 1 ou 0.',
    )]
    private ?bool $isAvailable = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    #[Assert\Range(
        min: 0,
        max: 999999.99,
        notInRangeMessage: 'Le prix HT doit être entre {{ min }} et {{ max }} €.',
    )]
    private ?string $priceHt = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 3, scale: 2)]
    #[Assert\Range(
        min: 0,
        max: 1,
        notInRangeMessage: 'La TVA doit être entre {{ min }} et {{ max }} de tva.',
    )]
    private ?string $tva = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\Length(
        max: 500,
        maxMessage: 'La description doit faire moins de {{ limit }} caractères.',
    )]
    private ?string $description = null;

    #[ORM\Column]
    #[Assert\NotBlank(
        message : 'La quantité ne peut pas être vide.'
    )]
    private ?int $quantity = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(
        message : 'La marque ne peut pas être vide.'
    )]
    private ?Brand $brand = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(
        message : 'La catégorie ne peut pas être vide.'
    )]
    private ?Category $category = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: InsideShoppingCart::class)]
    private Collection $insideShoppingCarts;

    public function __construct()
    {
        $this->insideShoppingCarts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function isIsAvailable(): ?bool
    {
        return $this->isAvailable;
    }

    public function setIsAvailable(bool $isAvailable): self
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }

    public function getPriceHt(): ?string
    {
        return $this->priceHt;
    }

    public function setPriceHt(string $priceHt): self
    {
        $this->priceHt = $priceHt;

        return $this;
    }

    public function getTva(): ?string
    {
        return $this->tva;
    }

    public function setTva(string $tva): self
    {
        $this->tva = $tva;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
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

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

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
            $insideShoppingCart->setProduct($this);
        }

        return $this;
    }

    public function removeInsideShoppingCart(InsideShoppingCart $insideShoppingCart): self
    {
        if ($this->insideShoppingCarts->removeElement($insideShoppingCart)) {
            // set the owning side to null (unless already changed)
            if ($insideShoppingCart->getProduct() === $this) {
                $insideShoppingCart->setProduct(null);
            }
        }

        return $this;
    }
}
