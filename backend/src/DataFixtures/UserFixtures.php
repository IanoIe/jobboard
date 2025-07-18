<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface as HasherUserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $passwordHasher;

    // Mudança para o UserPasswordHasherInterface
    public function __construct(HasherUserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setLastname('Pierre');
        $user->setFirstname('Jean');
        $user->setEmail('jean@gmail.com');
        $hashedPassword = $this->passwordHasher->hashPassword($user, '123');
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_ADMIN']);
        $user->setCvFilename('');
        $user->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris')));
        $manager->persist($user);

        $user = new User();
        $user->setLastname('Marlon');
        $user->setFirstname('Louis');
        $user->setEmail('marlon@hotmail.com');
        $hashedPassword = $this->passwordHasher->hashPassword($user, '12345');
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_USER']);
        $user->setCvFilename('');
        $user->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris')));
        $manager->persist($user);

        $user = new User();
        $user->setLastname('David');
        $user->setFirstname('Marmom');
        $user->setEmail('david@hotmail.com');
        $hashedPassword = $this->passwordHasher->hashPassword($user, '1234');
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_VIEWS']);
        $user->setCvFilename('');
        $user->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris')));
        $manager->persist($user);

        $manager->flush();
    }
}
