<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ApplicationJobController extends AbstractController
{
    #[Route('/application/job', name: 'app_application_job')]
    public function index(): Response
    {
        return $this->render('application_job/index.html.twig', [
            'controller_name' => 'ApplicationJobController',
        ]);
    }
}
