<?php

namespace App\Entity;

use App\Repository\BuildRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: BuildRepository::class)]
#[UniqueEntity('title', message: 'This title is already used')]
class Build
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Title cannot be blank.")]
    #[Assert\Length( min: 5, max: 255, minMessage: "Title cannot be shorter than {{ limit }} characters.", maxMessage: "Title cannot be longer than {{ limit }} characters."
    )]
    #[Assert\Regex(pattern: '/^[\w\s]+$/', message: 'Title can only contain letters, numbers, and spaces')]
    private ?string $title = null;

    #[ORM\Column]
    #[Assert\Type(type: 'bool', message: 'Visibility must be a boolean value.')]
    private ?bool $visibility = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updated = null;

    #[ORM\ManyToOne(inversedBy: 'builds')]
    private ?Champion $champion = null;

    /**
     * @var Collection<int, Ennemy>
     */
    #[ORM\OneToMany(targetEntity: Ennemy::class, mappedBy: 'build')]
    private Collection $ennemy;

    /**
     * @var Collection<int, Slot>
     */
    #[ORM\OneToMany(targetEntity: Slot::class, mappedBy: 'build', orphanRemoval: true, cascade:['persist'])]
    private Collection $slots;

    /**
     * @var Collection<int, Vote>
     */
    #[ORM\OneToMany(targetEntity: Vote::class, mappedBy: 'build')]
    private Collection $votes;

    #[ORM\ManyToOne(inversedBy: 'builds')]
    private ?User $creator = null;

    public function __construct()
    {
        $this->ennemy = new ArrayCollection();
        $this->slots = new ArrayCollection();
        $this->votes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function isVisibility(): ?bool
    {
        return $this->visibility;
    }

    public function setVisibility(bool $visibility): static
    {
        $this->visibility = $visibility;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): static
    {
        $this->created = $created;

        return $this;
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(\DateTimeInterface $updated): static
    {
        $this->updated = $updated;

        return $this;
    }

    public function getChampion(): ?Champion
    {
        return $this->champion;
    }

    public function setChampion(?Champion $champion): static
    {
        $this->champion = $champion;

        return $this;
    }

    /**
     * @return Collection<int, Ennemy>
     */
    public function getEnnemy(): Collection
    {
        return $this->ennemy;
    }

    public function addEnnemy(Ennemy $ennemy): static
    {
        if (!$this->ennemy->contains($ennemy)) {
            $this->ennemy->add($ennemy);
            $ennemy->setBuild($this);
        }

        return $this;
    }

    public function removeEnnemy(Ennemy $ennemy): static
    {
        if ($this->ennemy->removeElement($ennemy)) {
            // set the owning side to null (unless already changed)
            if ($ennemy->getBuild() === $this) {
                $ennemy->setBuild(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Slot>
     */
    public function getSlots(): Collection
    {
        return $this->slots;
    }

    public function addSlot(Slot $slot): static
    {
        if (!$this->slots->contains($slot)) {
            $this->slots->add($slot);
            $slot->setBuild($this);
        }

        return $this;
    }

    public function removeSlot(Slot $slot): static
    {
        if ($this->slots->removeElement($slot)) {
            // set the owning side to null (unless already changed)
            if ($slot->getBuild() === $this) {
                $slot->setBuild(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Vote>
     */
    public function getVotes(): Collection
    {
        return $this->votes;
    }

    public function addVote(Vote $vote): static
    {
        if (!$this->votes->contains($vote)) {
            $this->votes->add($vote);
            $vote->setBuild($this);
        }

        return $this;
    }

    public function removeVote(Vote $vote): static
    {
        if ($this->votes->removeElement($vote)) {
            // set the owning side to null (unless already changed)
            if ($vote->getBuild() === $this) {
                $vote->setBuild(null);
            }
        }

        return $this;
    }

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): static
    {
        $this->creator = $creator;

        return $this;
    }

}
