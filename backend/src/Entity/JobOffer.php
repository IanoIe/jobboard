<?php

namespace App\Entity;

use App\Entity\User;
use App\Repository\JobOfferRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: JobOfferRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read_jobOffer']],
    //denormalizationContext: ['groups' => ['write_jobOffer']],
    //security: 'is_granted("ROLE_USER")'
)]
#[GetCollection]
#[Get]
#[Post]
#[Patch]
#[Delete]
class JobOffer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read_jobOffer'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read_jobOffer'])]
    private ?string $nomEnterprise = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read_jobOffer'])]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read_jobOffer'])]
    private ?string $typeContract = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read_jobOffer'])]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'jobOffers')]
    private ?User $user = null;

    /**
     * @var Collection<int, ApplicationJob>
     */
    #[ORM\OneToMany(targetEntity: ApplicationJob::class, mappedBy: 'JobOffer')]
    private Collection $applicationJobs;

    public function __construct()
    {
        $this->applicationJobs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEnterprise(): ?string
    {
        return $this->nomEnterprise;
    }

    public function setNomEnterprise(string $nomEnterprise): static
    {
        $this->nomEnterprise = $nomEnterprise;

        return $this;
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

    public function getTypeContract(): ?string
    {
        return $this->typeContract;
    }

    public function setTypeContract(string $typeContract): static
    {
        $this->typeContract = $typeContract;

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

    /**
     * @return Collection<int, ApplicationJob>
     */
    public function getApplicationJobs(): Collection
    {
        return $this->applicationJobs;
    }

    public function addApplicationJob(ApplicationJob $applicationJob): static
    {
        if (!$this->applicationJobs->contains($applicationJob)) {
            $this->applicationJobs->add($applicationJob);
            $applicationJob->setJobOffer($this);
        }

        return $this;
    }

    public function removeApplicationJob(ApplicationJob $applicationJob): static
    {
        if ($this->applicationJobs->removeElement($applicationJob)) {
            // set the owning side to null (unless already changed)
            if ($applicationJob->getJobOffer() === $this) {
                $applicationJob->setJobOffer(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->title . ', ' . $this->nomEnterprise;
    }

}
