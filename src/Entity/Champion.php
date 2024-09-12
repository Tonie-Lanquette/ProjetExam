<?php

namespace App\Entity;

use App\Repository\ChampionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChampionRepository::class)]
class Champion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $role = null;

    #[ORM\Column(length: 255)]
    private ?string $splash_art = null;

    #[ORM\Column]
    private ?int $championKey = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'favorite')]
    private Collection $favor;

    /**
     * @var Collection<int, Build>
     */
    #[ORM\OneToMany(targetEntity: Build::class, mappedBy: 'champion')]
    private Collection $builds;

    /**
     * @var Collection<int, Ennemy>
     */
    #[ORM\ManyToMany(targetEntity: Ennemy::class, mappedBy: 'champion')]
    private Collection $ennemies;

    public function __construct()
    {
        $this->favor = new ArrayCollection();
        $this->builds = new ArrayCollection();
        $this->ennemies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getSplashArt(): ?string
    {
        return $this->splash_art;
    }

    public function setSplashArt(string $splash_art): static
    {
        $this->splash_art = $splash_art;

        return $this;
    }

    public function getChampionKey(): ?int
    {
        return $this->championKey;
    }

    public function setChampionKey(int $championKey): static
    {
        $this->championKey = $championKey;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getFavor(): Collection
    {
        return $this->favor;
    }

    public function addFavor(User $favor): static
    {
        if (!$this->favor->contains($favor)) {
            $this->favor->add($favor);
            $favor->addFavorite($this);
        }

        return $this;
    }

    public function removeFavor(User $favor): static
    {
        if ($this->favor->removeElement($favor)) {
            $favor->removeFavorite($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Build>
     */
    public function getBuilds(): Collection
    {
        return $this->builds;
    }

    public function addBuild(Build $build): static
    {
        if (!$this->builds->contains($build)) {
            $this->builds->add($build);
            $build->setChampion($this);
        }

        return $this;
    }

    public function removeBuild(Build $build): static
    {
        if ($this->builds->removeElement($build)) {
            // set the owning side to null (unless already changed)
            if ($build->getChampion() === $this) {
                $build->setChampion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Ennemy>
     */
    public function getEnnemies(): Collection
    {
        return $this->ennemies;
    }

    public function addEnnemy(Ennemy $ennemy): static
    {
        if (!$this->ennemies->contains($ennemy)) {
            $this->ennemies->add($ennemy);
            $ennemy->addChampion($this);
        }

        return $this;
    }

    public function removeEnnemy(Ennemy $ennemy): static
    {
        if ($this->ennemies->removeElement($ennemy)) {
            $ennemy->removeChampion($this);
        }

        return $this;
    }
}
