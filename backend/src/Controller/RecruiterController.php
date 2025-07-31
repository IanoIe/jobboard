<?php

namespace App\Controller;

use App\Repository\JobOfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class RecruiterController extends AbstractController
{
    private JobOfferRepository $jobOfferRepository;

    public function __construct(JobOfferRepository $jobOfferRepository)
    {
        $this->jobOfferRepository = $jobOfferRepository;
    }

    #[Route('/api/job-offers/mine', name: 'api_job_offers_mine', methods: ['GET'])]
    public function myJobOffers(): JsonResponse
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->json(['error' => 'Unauthorized'], 401);
        }

        $offers = $this->jobOfferRepository->findBy(['user' => $user]);

        return $this->json($offers, 200, [], ['groups' => ['read_jobOffer']]);
    }
}
