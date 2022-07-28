<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $zipCode = null;

    #[ORM\Column(length: 80)]
    private ?string $country = null;

    #[ORM\Column(length: 80)]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    private ?string $row1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $row2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $row3 = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'address')]
    private Collection $users;


    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getZipCode(): ?int
    {
        return $this->zipCode;
    }

    public function setZipCode(int $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getRow1(): ?string
    {
        return $this->row1;
    }

    public function setRow1(string $row1): self
    {
        $this->row1 = $row1;

        return $this;
    }

    public function getRow2(): ?string
    {
        return $this->row2;
    }

    public function setRow2(?string $row2): self
    {
        $this->row2 = $row2;

        return $this;
    }

    public function getRow3(): ?string
    {
        return $this->row3;
    }

    public function setRow3(?string $row3): self
    {
        $this->row3 = $row3;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addAddress($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeAddress($this);
        }

        return $this;
    }

}
