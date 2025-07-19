<?php

namespace App\DataFixtures;

use App\Entity\ApplicationJob;
use App\Entity\JobOffer;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ApplicationJobFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $user = $manager->getRepository(User::class)->findOneBy(['email' => 'jean@gmail.com']);
        $jobOffer = $manager->getRepository(JobOffer::class)->findOneBy(['title' => 'Developpeur Junior H/F']);

        if ($user && $jobOffer) {
            $applicationJob = new ApplicationJob();
            $applicationJob->setUser($user);
            $applicationJob->setJobOffer($jobOffer);
            $applicationJob->setState('Accept');
            $applicationJob->setEmail('jean@gmail.com');
            $cvPath = 'C:\Users\AC Marvel\Downloads\Fille_CV.pdf';
            if (file_exists($cvPath)) {
                $cvContent = file_get_contents($cvPath);
                $applicationJob->setCvData($cvContent);
            } else {
                throw new \Exception("Don´t CV: $cvPath");
            }

            $createdAt = new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris'));
            $applicationJob->setCreatedAt($createdAt);
            $manager->persist($applicationJob);
        } else {
            throw new \Exception('User or Job Offer not found!');
        }

        $user = $manager->getRepository(User::class)->findOneBy(['email' => 'marlon@hotmail.com']);
        $jobOffer = $manager->getRepository(JobOffer::class)->findOneBy(['title' => "Agent d'Accueil Pension de Famille H/F"]);

        if ($user && $jobOffer) {
            $applicationJob = new ApplicationJob();
            $applicationJob->setUser($user);
            $applicationJob->setJobOffer($jobOffer);
            $applicationJob->setState('Refus');
            $applicationJob->setEmail('marlon@hotmail.com');
            $cvPath = 'C:\Users\AC Marvel\Downloads\Fille_CV.pdf';
            if (file_exists($cvPath)) {
                $cvContent = file_get_contents($cvPath);
                $applicationJob->setCvData($cvContent);
            } else {
                throw new \Exception("Don´t CV: $cvPath");
            }

            $createdAt = new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris'));
            $applicationJob->setCreatedAt($createdAt);
            $manager->persist($applicationJob);
        } else {
            throw new \Exception('User or Job Offer not found!');
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            JobOfferFixtures::class,
        ];
    }
}
