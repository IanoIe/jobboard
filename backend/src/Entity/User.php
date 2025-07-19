<?php


namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

use ApiPlatform\Metadata as Api;
use App\Controller\Api\MeAction;
use Symfony\Component\Serializer\Attribute\Groups;

use ApiPlatform\OpenApi\Model;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[Api\ApiResource(
    normalizationContext: ['groups' => ['read_user', 'read_views']],
    denormalizationContext: ['groups' => ['write_user', 'write_views']],
)]
#[Api\Get(
    uriTemplate: '/me',
    security: 'is_granted("ROLE_USER")',
    read: false,
    controller: MeAction::class,
    openapi: new Model\Operation(
        summary: 'Show current user profile'
    )
)]
#[Api\Patch(
    security: 'is_granted("ROLE_USER") and object.id == user.id',
)]
#[Api\Delete(
    security: 'is_granted("ROLE_USER") and object.id == user.id',
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    private ?string $plainPassword = null;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read_user'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read_user', 'write_user'])]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read_user', 'write_user'])]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read_user', 'write_user'])]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column]
    #[Groups(['read_user', 'write_user'])]
    private array $roles = [];



    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, JobOffer>
     */
    #[ORM\OneToMany(targetEntity: JobOffer::class, mappedBy: 'user')]
    private Collection $jobOffers;

    /**
     * @var Collection<int, ApplicationJob>
     */
    #[ORM\OneToMany(targetEntity: ApplicationJob::class, mappedBy: 'user')]
    private Collection $applicationJobs;

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

    public function __construct()
    {
        $this->jobOffers = new ArrayCollection();
        $this->applicationJobs = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
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

    public function getJobOffers(): Collection
    {
        return $this->jobOffers;
    }

    public function addJobOffer(JobOffer $jobOffer): static
    {
        if (!$this->jobOffers->contains($jobOffer)) {
            $this->jobOffers->add($jobOffer);
            $jobOffer->setUser($this);
        }
        return $this;
    }

    public function removeJobOffer(JobOffer $jobOffer): static
    {
        if ($this->jobOffers->removeElement($jobOffer)) {
            if ($jobOffer->getUser() === $this) {
                $jobOffer->setUser(null);
            }
        }
        return $this;
    }

    public function getApplicationJobs(): Collection
    {
        return $this->applicationJobs;
    }

    public function addApplicationJob(ApplicationJob $applicationJob): static
    {
        if (!$this->applicationJobs->contains($applicationJob)) {
            $this->applicationJobs->add($applicationJob);
            $applicationJob->setUser($this);
        }
        return $this;
    }

    public function removeApplicationJob(ApplicationJob $applicationJob): static
    {
        if ($this->applicationJobs->removeElement($applicationJob)) {
            if ($applicationJob->getUser() === $this) {
                $applicationJob->setUser(null);
            }
        }
        return $this;
    }

    public function eraseCredentials(): void
    {

    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function __toString(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }
}
