<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixtures extends Fixture
{
    public const TEST_USER = 'TEST_USER';
    public const TEST_RECRUITER_1 = 'TEST_RECRUITER_1';
    public const TEST_RECRUITER_2 = 'TEST_RECRUITER_2';
    public const TEST_RECRUITER_3 = 'TEST_RECRUITER_3';
    private $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher)

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
        $user->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris')));
        $manager->persist($user);
        $this->addReference(self::TEST_USER, $user);

        $user = new User();
        $user->setLastname('Marlon');
        $user->setFirstname('Louis');
        $user->setEmail('marlon@hotmail.com');
        $hashedPassword = $this->passwordHasher->hashPassword($user, '12345');
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_RECRUITER']);
        $user->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris')));
        $manager->persist($user);
        $this->addReference(self::TEST_RECRUITER_1, $user);

        $user = new User();
        $user->setLastname('David');
        $user->setFirstname('Marmom');
        $user->setEmail('david@hotmail.com');
        $hashedPassword = $this->passwordHasher->hashPassword($user, '1234');
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_RECRUITER']);
        $user->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris')));
        $manager->persist($user);
        $this->addReference(self::TEST_RECRUITER_2, $user);

        $manager->flush();
    }
}
