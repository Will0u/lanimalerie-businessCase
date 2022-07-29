<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
#[ApiResource(
    attributes: [
        "security" => "is_granted('ROLE_ADMIN')",
        "security_message" => "Accès refusé."
    ],
    collectionOperations: [
        "get",
        "post",
    ],
    itemOperations: [
        "get",
        "put",
        "delete",
        "patch"
    ],
)]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\Range(
        min: 0,
        max: 5,
        notInRangeMessage: '{{label}} doit être entre {{min}} et {{max}}.',
    )]
    private ?int $mark = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\Length(
        max: 500,
        maxMessage: '{{label}} doit faire moins de {{limit}} caractères.',
    )]
    private ?string $comment = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank(
        message : '{{ label }} ne peut pas être vide.'
    )]
    #[Assert\LessThan('now')]
    private ?\DateTimeInterface $wroteAt = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'review')]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMark(): ?int
    {
        return $this->mark;
    }

    public function setMark(int $mark): self
    {
        $this->mark = $mark;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getWroteAt(): ?\DateTimeInterface
    {
        return $this->wroteAt;
    }

    public function setWroteAt(\DateTimeInterface $wroteAt): self
    {
        $this->wroteAt = $wroteAt;

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
            $user->addReview($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeReview($this);
        }

        return $this;
    }
}
