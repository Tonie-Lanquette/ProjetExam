<?php

namespace App\Entity;

use App\Repository\EnnemyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnnemyRepository::class)]
class Ennemy
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $category = null;

    #[ORM\ManyToOne(inversedBy: 'ennemy')]
    private ?Build $build = null;

    /**
     * @var Collection<int, Champion>
     */
    #[ORM\ManyToMany(targetEntity: Champion::class, inversedBy: 'ennemies')]
    private Collection $champion;

    public function __construct()
    {
        $this->champion = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getBuild(): ?Build
    {
        return $this->build;
    }

    public function setBuild(?Build $build): static
    {
        $this->build = $build;

        return $this;
    }

    /**
     * @return Collection<int, Champion>
     */
    public function getChampion(): Collection
    {
        return $this->champion;
    }

    public function addChampion(Champion $champion): static
    {
        if (!$this->champion->contains($champion)) {
            $this->champion->add($champion);
        }

        return $this;
    }

    public function removeChampion(Champion $champion): static
    {
        $this->champion->removeElement($champion);

        return $this;
    }
}
