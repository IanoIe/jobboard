<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UserCrudController extends AbstractCrudController
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield Field::new('firstname')->setLabel('First Name');
        yield Field::new('lastname')->setLabel('Last Name');
        yield Field::new('email');
        yield Field::new('plainPassword')
            ->onlyOnForms()
            ->setLabel('Password');

        yield ChoiceField::new('roles')
            ->allowMultipleChoices()
            ->renderExpanded()
            ->setChoices([
                'User' => 'ROLE_USER',
                'Admin' => 'ROLE_ADMIN',
            ]);
        yield Field::new('cvFilename')->setLabel('CV');
        yield Field::new('createdAt')->setLabel('Date');
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        /** @var User $entityInstance */
        $this->encodePassword($entityInstance);

        if (empty($entityInstance->getRoles())) {
            $entityInstance->setRoles(['ROLE_USER']);
        }
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        /** @var User $entityInstance */
        $this->encodePassword($entityInstance);
        if (empty($entityInstance->getRoles())) {
            $entityInstance->setRoles(['ROLE_USER']);
        }
        parent::updateEntity($entityManager, $entityInstance);
    }

    private function encodePassword(User $user): void
    {
        $plainPassword = $user->getPlainPassword();
        if ($plainPassword) {
            $hashed = $this->passwordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashed);
            $user->setPlainPassword(null);
        }
    }
}

