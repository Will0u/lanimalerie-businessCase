<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    attributes: [
        "security" => "is_granted('ROLE_ADMIN')",
        "security_message" => "Accès refusé."
    ],
    collectionOperations: [
    ],
    itemOperations: [
        "get",
    ],
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\Length(
        min: 2,
        max: 180,
        minMessage: 'L\'adresse email doit faire plus de {{ limit }} caractères.',
        maxMessage: 'L\'adresse email doit faire moins de {{ limit }} caractères.',
    )]
    #[Assert\Email(
        message: 'L\'adresse email : "{{ value }}" est invalide.',
    )]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\Length(
        min: 4,
        max: 30,
        minMessage: 'Le mot de passe doit faire plus de {{ limit }} caractères.',
        maxMessage: 'Le mot de passe doit faire moins de {{ limit }} caractères.',
    )]
    private ?string $password = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank(
        message : 'La date de naissance ne peut pas être vide.'
    )]
    #[Assert\LessThan(
        '-18 years' , 
        message: 'Vous devez avoir plus de 18 ans.'
    )]
    private ?\DateTimeInterface $birthAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank(
        message : 'La date de création ne peut pas être vide.'
    )]
    #[Assert\LessThan('now')]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(length: 80)]
    #[Assert\Length(
        min: 2,
        max: 80,
        minMessage: 'Le prénom doit faire plus de {{ limit }} caractères.',
        maxMessage: 'Le prénom doit faire moins de {{ limit }} caractères.',
    )]
    #[Groups("bill")]
    private ?string $firstName = null;

    #[ORM\Column(length: 80)]
    #[Assert\Length(
        min: 2,
        max: 80,
        minMessage: 'Le nom de famille doit faire plus de {{ limit }} caractères.',
        maxMessage: 'Le nom de famille doit faire moins de {{ limit }} caractères.',
    )]
    #[Groups("bill")]
    private ?string $lastName = null;


    #[ORM\ManyToMany(targetEntity: Review::class, inversedBy: 'users')]
    private Collection $review;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: ShoppingCart::class)]
    private Collection $shoppingCart;

    #[ORM\ManyToMany(targetEntity: Address::class, inversedBy: 'users')]
    #[Groups("bill")]
    private Collection $address;

    #[ORM\Column(length: 18, unique: true )]
    #[Assert\Length(
        min: 2,
        max: 18,
        minMessage: 'Votre pseudo doit faire plus de {{ limit }} caractères.',
        maxMessage: 'Votre pseudo doit faire moins de {{ limit }} caractères.',
    )]
    private ?string $username = null;


    public function __construct()
    {
        $this->review = new ArrayCollection();
        $this->shoppingCart = new ArrayCollection();
        $this->address = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getBirthAt(): ?\DateTimeInterface
    {
        return $this->birthAt;
    }

    public function setBirthAt(\DateTimeInterface $birthAt): self
    {
        $this->birthAt = $birthAt;

        return $this;
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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }
    

    /**
     * @return Collection<int, Review>
     */
    public function getReview(): Collection
    {
        return $this->review;
    }

    public function addReview(Review $review): self
    {
        if (!$this->review->contains($review)) {
            $this->review->add($review);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        $this->review->removeElement($review);

        return $this;
    }

    /**
     * @return Collection<int, ShoppingCart>
     */
    public function getShoppingCart(): Collection
    {
        return $this->shoppingCart;
    }

    public function addShoppingCart(ShoppingCart $shoppingCart): self
    {
        if (!$this->shoppingCart->contains($shoppingCart)) {
            $this->shoppingCart->add($shoppingCart);
            $shoppingCart->setUser($this);
        }

        return $this;
    }

    public function removeShoppingCart(ShoppingCart $shoppingCart): self
    {
        if ($this->shoppingCart->removeElement($shoppingCart)) {
            // set the owning side to null (unless already changed)
            if ($shoppingCart->getUser() === $this) {
                $shoppingCart->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Address>
     */
    public function getAddress(): Collection
    {
        return $this->address;
    }

    public function addAddress(Address $address): self
    {
        if (!$this->address->contains($address)) {
            $this->address->add($address);
        }

        return $this;
    }

    public function removeAddress(Address $address): self
    {
        $this->address->removeElement($address);

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

}
