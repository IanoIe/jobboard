<?php

namespace App\Controller;

use App\Entity\ApplicationJob;
use App\Repository\JobOfferRepository;
use App\Service\NotificationService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class ApplicationJobController extends AbstractController
{
    #[Route('/application/job', name: 'app_application_job')]
    public function index(): JsonResponse
    {
        return new JsonResponse(['message' => 'ApplicationJobController is working']);
    }

    #[Route('/api/applications/upload', name: 'application_upload', methods: ['POST'])]
    public function upload(
        Request $request,
        EntityManagerInterface $em,
        JobOfferRepository $jobOfferRepository,
        NotificationService $notificationService,
        LoggerInterface $logger
    ): JsonResponse {
        $email = trim($request->request->get('email'));
        $rawFullName = $request->request->get('fullName');
        $fullName = trim($rawFullName);
        $jobId = $request->request->get('jobId');
        $cvFile = $request->files->get('cv');

        // Validate required fields
        if (empty($email) || empty($jobId) || !$cvFile) {
            $logger->warning('Application with missing mandatory fields.', [
                'email' => $email,
                'jobId' => $jobId,
                'cvFile' => $cvFile ? 'sent' : 'not sent'
            ]);
            return new JsonResponse(['error' => 'Missing required fields'], 400);
        }

        // Use default if fullName is empty after trimming
        if (empty($fullName)) {
            $fullName = 'Anónimo';
        }

        // Validate job offer exists
        $jobOffer = $jobOfferRepository->find($jobId);
        if (!$jobOffer) {
            $logger->error("Job offer not found with ID $jobId");
            return new JsonResponse(['error' => 'Job offer not found'], 404);
        }

        // Process CV file
        $cvData = file_get_contents($cvFile->getPathname());

        // Create application
        $application = new ApplicationJob();
        $application->setEmail($email);
        $application->setFullName($fullName);
        $application->setCvData($cvData);
        $application->setState('submitted');
        $application->setCreatedAt(new \DateTimeImmutable());
        $application->setJobOffer($jobOffer);

        $em->persist($application);
        $em->flush();

        // Send notification emails
        try {
            $recruiter = $jobOffer->getUser();
            $recruiterEmail = $recruiter ? $recruiter->getEmail() : 'default@empresa.com';

            $applicationData = [
                'fullName' => $fullName,
                'email' => $email,
                'cvData' => $cvData,
            ];

            $notificationService->notifyNewApplication(
                $recruiterEmail,
                $applicationData,
                $jobOffer->getTitle()
            );

            $notificationService->notifyApplicationConfirmation(
                $email,
                $fullName,
                $jobOffer->getTitle()
            );

            $logger->info('Application submitted successfully.', [
                'email' => $email,
                'jobId' => $jobId,
                'recruiterEmail' => $recruiterEmail
            ]);

        } catch (\Throwable $e) {
            $logger->error('Error sending notification emails: ' . $e->getMessage());
        }

        return new JsonResponse(['message' => 'Application sent successfully'], 201);
    }
}

