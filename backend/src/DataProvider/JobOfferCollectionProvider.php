<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\JobOfferRepository;
use Symfony\Bundle\SecurityBundle\Security;

class JobOfferCollectionProvider implements ProviderInterface
{
    public function __construct(
        private JobOfferRepository $jobOfferRepository,
        private Security $security
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): iterable
    {
        $user = $this->security->getUser();

        if (!$user) {
            return [];
        }

        if ($this->security->isGranted('ROLE_ADMIN')) {
            return $this->jobOfferRepository->findAll();
        }

        if ($this->security->isGranted('ROLE_RECRUITER')) {
            return $this->jobOfferRepository->findBy(['user' => $user]);
        }

        return []; 
    }
}
