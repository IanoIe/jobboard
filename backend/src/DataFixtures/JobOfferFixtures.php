<?php

namespace App\DataFixtures;

use App\Entity\JobOffer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class JobOfferFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $jobOffer = new JobOffer();
        $jobOffer->setNomEnterprise('Hi Tech');
        $jobOffer->setTitle('Developpeur Junior H/F');
        $jobOffer->setTypeContract('CDI / CDD');
        $jobOffer->setDescription('Découper et intégrer les designs ou maquettes en utilisant
                                   les langages de développement appropriés: HTML, CSS, PHP, JAVASCRIPT, Smarty, SQL et XM');
        $jobOffer->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris')));
        $manager->persist($jobOffer);

        $jobOffer = new JobOffer();
        $jobOffer->setNomEnterprise('Adoma');
        $jobOffer->setTitle("Agent d'Accueil Pension de Famille H/F");
        $jobOffer->setTypeContract('CDI / CDD / Interim');
        $jobOffer->setDescription("L'accueil et la bonne installation des résidents;
                                   - La présentation du fonctionnement de la pension de famille;");
        $jobOffer->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris')));
        $manager->persist($jobOffer);



        $jobOffer = new JobOffer();
        $jobOffer->setNomEnterprise('Vinci Immobilier');
        $jobOffer->setTitle("Analyste Risques H/F");
        $jobOffer->setTypeContract('CDI / CDD / Interim');
        $jobOffer->setDescription("De réaliser l'évaluation renforcée des tiers et des transactions;
                                   - De rédiger, si besoin, des procédures, guides ou supports à destination des équipes opérationnelles et supports;");
        $jobOffer->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris')));
        $manager->persist($jobOffer);


        $jobOffer = new JobOffer();
        $jobOffer->setNomEnterprise('BPCE SA');
        $jobOffer->setTitle("Technology Risk Management Officer H/F");
        $jobOffer->setTypeContract('CDI / CDD / Interim');
        $jobOffer->setDescription("Superviser les contrôles permanents Groupe de niveau 1 (CPN1);
                                   - Un modèle managérial favorisant la mise en responsabilité et la prise d'initiatives;");
        $jobOffer->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris')));
        $manager->persist($jobOffer);

        $manager->flush();
    }
}
