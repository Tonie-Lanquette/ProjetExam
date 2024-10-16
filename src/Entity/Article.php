<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[UniqueEntity(fields: ['title'], message: 'An article with this title already exists')]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Title cannot be blank")]
    #[Assert\Length( min: 5, max: 60, minMessage: "Title must be at least {{ limit }} characters long", maxMessage: "Title cannot be longer than {{ limit }} characters")]
    #[Assert\Regex(pattern: '/^[\w\s]+$/', message: "Title can only contain letters, numbers, and spaces")]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: "Title cannot be blank")]
    #[Assert\Length(min: 5, max: 65535, minMessage: "This field must be at least {{ limit }} characters long", maxMessage: "This field cannot be longer than {{ limit }} characters")]
    #[Assert\Regex(pattern: '/^[\p{L}\p{N}\s.,!?\'"’-]*$/u', message: 'This field can only contain letters, numbers, and basic punctuation.')]
    #[Assert\Type(type: 'string', message: 'This field must be a string.')]
    private ?string $introduction = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: "Title cannot be blank")]
    #[Assert\Length(min: 5, max: 65535, minMessage: "This field must be at least {{ limit }} characters long", maxMessage: "This field cannot be longer than {{ limit }} characters")]
    #[Assert\Regex(pattern: '/^[\p{L}\p{N}\s.,!?\'"’-]*$/u', message: 'This field can only contain letters, numbers, and basic punctuation.')]
    #[Assert\Type(type: 'string', message: 'This field must be a string.')]
    private ?string $starter_explication = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: "Title cannot be blank")]
    #[Assert\Length(min: 5, max: 65535, minMessage: "This field must be at least {{ limit }} characters long", maxMessage: "This field cannot be longer than {{ limit }} characters")]
    #[Assert\Regex(pattern: '/^[\p{L}\p{N}\s.,!?\'"’-]*$/u', message: 'This field can only contain letters, numbers, and basic punctuation.')]
    #[Assert\Type(type: 'string', message: 'This field must be a string.')]
    private ?string $core_explication = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: "Title cannot be blank")]
    #[Assert\Length(min: 5, max: 65535, minMessage: "This field must be at least {{ limit }} characters long", maxMessage: "This field cannot be longer than {{ limit }} characters")]
    #[Assert\Regex(pattern: '/^[\p{L}\p{N}\s.,!?\'"’-]*$/u', message: 'This field can only contain letters, numbers, and basic punctuation.')]
    #[Assert\Type(type: 'string', message: 'This field must be a string.')]
    private ?string $optional_explication = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: "Title cannot be blank")]
    #[Assert\Length(min: 5, max: 65535, minMessage: "This field must be at least {{ limit }} characters long", maxMessage: "This field cannot be longer than {{ limit }} characters")]
    #[Assert\Regex(pattern: '/^[\p{L}\p{N}\s.,!?\'"’-]*$/u', message: 'This field can only contain letters, numbers, and basic punctuation.')]
    #[Assert\Type(type: 'string', message: 'This field must be a string.')]
    private ?string $conclusion = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    private ?User $user = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private ?Build $build = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created = null;

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

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): static
    {
        $this->created = $created;

        return $this;
    }
}
