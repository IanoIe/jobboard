<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setLastname('Pierre');
        $user->setFirstname('Jean');
        $user->setEmail('jean@gmail.com');
        $user->setPlainPassword('123');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setCvFilename('');
        $user->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris')));
        $manager->persist($user);

        $user = new User();
        $user->setLastname('Marlon');
        $user->setFirstname('Louis');
        $user->setEmail('marlon@hotmail.com');
        $user->setPlainPassword('12345');
        $user->setRoles(['ROLE_USER']);
        $user->setCvFilename('');
        $user->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris')));
        $manager->persist($user);

        $manager->flush();
    }
}
