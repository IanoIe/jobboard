<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class NotificationService
{
    private MailerInterface $mailer;
    private Environment $twig;

    public function __construct(MailerInterface $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    /**
     * @param string $toEmail Email do recrutador
     * @param array $applicationData ['fullName' => ..., 'email' => ..., 'cvData' => ...]
     * @param string $jobOfferTitle Título da vaga
     */
    public function notifyNewApplication(string $toEmail, array $applicationData, string $jobOfferTitle): void
    {
        $email = (new Email())
            ->from('no-reply@teusite.com')
            ->to($toEmail)
            ->subject('Nova candidatura para a vaga: ' . $jobOfferTitle)
            ->html(
                $this->twig->render('emails/new_application.html.twig', [
                    'jobOfferTitle' => $jobOfferTitle,
                    'candidate' => [
                        'fullName' => $applicationData['fullName'] ?? 'Desconhecido',
                        'email' => $applicationData['email'] ?? 'Sem email',
                    ],
                ])
            );

        // Anexar o CV em PDF (se houver)
        if (!empty($applicationData['cvData'])) {
            $cvFileName = 'CV_' . ($applicationData['fullName'] ?? 'candidate') . '.pdf';
            $email->attach($applicationData['cvData'], $cvFileName, 'application/pdf');
        }

        $this->mailer->send($email);
    }

    public function notifyApplicationConfirmation(string $toEmail, string $fullName, string $jobOfferTitle): void
    {
        $email = (new Email())
            ->from('no-reply@teusite.com')
            ->to($toEmail)
            ->subject('Candidatura recebida com sucesso')
            ->html(
                $this->twig->render('emails/application_confirmation.html.twig', [
                    'fullName' => $fullName,
                    'jobOfferTitle' => $jobOfferTitle,
                ])
            );
        $this->mailer->send($email);
    }
}
