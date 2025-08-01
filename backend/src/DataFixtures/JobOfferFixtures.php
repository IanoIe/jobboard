<?php

namespace App\DataFixtures;

use App\Entity\JobOffer;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class JobOfferFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $jobOffer1 = new JobOffer();
        $jobOffer1->setNomEnterprise('Hi Tech');
        $jobOffer1->setTitle('Developpeur Junior H/F');
        $jobOffer1->setTypeContract('CDI / CDD');
        $jobOffer1->setDescription('Découper et intégrer les designs ou maquettes en utilisant
                                   les langages de développement appropriés: HTML, CSS, PHP, JAVASCRIPT, Smarty, SQL et XM');
        $jobOffer1->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris')));
        $jobOffer1->setUser($this->getReference(UserFixtures::TEST_USER, User::class));
        $manager->persist($jobOffer1);

        $jobOffer2 = new JobOffer();
        $jobOffer2->setNomEnterprise('Adoma');
        $jobOffer2->setTitle("Agent d'Accueil Pension de Famille H/F");
        $jobOffer2->setTypeContract('CDI / CDD / Interim');
        $jobOffer2->setDescription("L'accueil et la bonne installation des résidents;
                                   - La présentation du fonctionnement de la pension de famille;");
        $jobOffer2->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris')));
        $jobOffer2->setUser($this->getReference(UserFixtures::TEST_RECRUITER_1, User::class));
        $manager->persist($jobOffer2);

        $jobOffer3 = new JobOffer();
        $jobOffer3->setNomEnterprise('Vinci Immobilier');
        $jobOffer3->setTitle("Analyste Risques H/F");
        $jobOffer3->setTypeContract('CDI / CDD / Interim');
        $jobOffer3->setDescription("De réaliser l'évaluation renforcée des tiers et des transactions;
                                   - De rédiger, si besoin, des procédures, guides ou supports à destination des équipes opérationnelles et supports;");
        $jobOffer3->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris')));
        $jobOffer3->setUser($this->getReference(UserFixtures::TEST_RECRUITER_2, User::class));
        $manager->persist($jobOffer3);

        $jobOffer3 = new JobOffer();
        $jobOffer3->setNomEnterprise('Vinci ');
        $jobOffer3->setTitle("Analyste Risques H/F");
        $jobOffer3->setTypeContract('CDI / CDD / Interim');
        $jobOffer3->setDescription("De réaliser l'évaluation renforcée des tiers et des transactions;
                                   - De rédiger, si besoin, des...");
        $jobOffer3->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris')));
        $jobOffer3->setUser($this->getReference(UserFixtures::TEST_RECRUITER_2, User::class));
        $manager->persist($jobOffer3);

        $jobOffer2 = new JobOffer();
        $jobOffer2->setNomEnterprise('Adoma 5');
        $jobOffer2->setTitle("Agent d'Accueil Pension de Famille H/F");
        $jobOffer2->setTypeContract('Interim');
        $jobOffer2->setDescription("L'accueil et la bonne installation des résidents");
        $jobOffer2->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris')));
        $jobOffer2->setUser($this->getReference(UserFixtures::TEST_RECRUITER_1, User::class));
        $manager->persist($jobOffer2);


        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
