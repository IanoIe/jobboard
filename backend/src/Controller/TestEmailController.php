<?php

namespace App\Controller;

use App\Service\NotificationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TestEmailController extends AbstractController
{
    #[Route('/test/email', name: 'app_test_email')]
    public function index(NotificationService $notificationService): Response
    {
        $toEmail = 'aureliano-ca@hotmail.com';
        $applicationData = [
            'fullName' => 'Candidate Example',
            'email' => 'caditato@example.com',
            'message' => "Estou interessado na vaga.",
            'cvData' => file_get_contents('/caminho/para/um/cv.pdf'),
        ];
        $jobOffertTitle = 'Desenvolver Full Stack';

        $notificationService->notifyNewApplication($toEmail, $applicationData, $jobOffertTitle);

        return new Response('✅ Email de teste enviado com sucesso!');
    }
}
