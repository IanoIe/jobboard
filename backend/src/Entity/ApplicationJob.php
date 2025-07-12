<?php

namespace App\Entity;

use App\Repository\ApplicationJobRepository;
use Doctrine\ORM\Mapping as ORM;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: ApplicationJobRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read_applicationJob']],
    //denormalizationContext: ['groups' => ['write_applicationJob']],
    //security: 'is_granted("ROLE_USER")'
)]
#[GetCollection]
#[Get]
#[Post]
#[Patch]
#[Delete]

class ApplicationJob
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read_applicationJob'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read_applicationJob'])]
    private ?string $state = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'JobOffer')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'applicationJobs')]
    private ?JobOffer $jobOffer = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

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

    public function getJobOffer(): ?JobOffer
    {
        return $this->jobOffer;
    }

    public function setJobOffer(?JobOffer $jobOffer): static
    {
        $this->jobOffer = $jobOffer;

        return $this;
    }
}
