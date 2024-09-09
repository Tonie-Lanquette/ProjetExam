<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $introduction = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $starter_explication = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $core_explication = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $optional_explication = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $conclusion = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    private ?User $user = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Build $build = null;

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

    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    public function setIntroduction(string $introduction): static
    {
        $this->introduction = $introduction;

        return $this;
    }

    public function getStarterExplication(): ?string
    {
        return $this->starter_explication;
    }

    public function setStarterExplication(string $starter_explication): static
    {
        $this->starter_explication = $starter_explication;

        return $this;
    }

    public function getCoreExplication(): ?string
    {
        return $this->core_explication;
    }

    public function setCoreExplication(string $core_explication): static
    {
        $this->core_explication = $core_explication;

        return $this;
    }

    public function getOptionalExplication(): ?string
    {
        return $this->optional_explication;
    }

    public function setOptionalExplication(string $optional_explication): static
    {
        $this->optional_explication = $optional_explication;

        return $this;
    }

    public function getConclusion(): ?string
    {
        return $this->conclusion;
    }

    public function setConclusion(string $conclusion): static
    {
        $this->conclusion = $conclusion;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

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
}
