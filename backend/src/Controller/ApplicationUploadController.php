<?php

namespace App\Controller;

use App\Entity\ApplicationJob;
use App\Repository\JobOfferRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class ApplicationUploadController extends AbstractController
{
    #[Route('/api/applications/upload', name: 'application_upload', methods: ['POST'])]
    public function upload(
        Request $request,
        EntityManagerInterface $em,
        JobOfferRepository $jobOfferRepository
    ): JsonResponse {
        $email = $request->request->get('email');
        $jobId = $request->request->get('jobId');
        $cvFile = $request->files->get('cv');

        if (!$email || !$jobId || !$cvFile) {
            return new JsonResponse(['error' => 'Missing required fields'], 400);
        }

        $jobOffer = $jobOfferRepository->find($jobId);
        if (!$jobOffer) {
            return new JsonResponse(['error' => 'Job offer not found'], 404);
        }

        $cvData = file_get_contents($cvFile->getPathname());

        $application = new ApplicationJob();
        $application->setEmail($email);
        $application->setCvData($cvData);
        $application->setState('submitted');
        $application->setCreatedAt(new \DateTimeImmutable());
        $application->setJobOffer($jobOffer);
        $em->persist($application);
        $em->flush();

        return new JsonResponse(['message' => 'Application submitted successfully'], 201);
    }
}
