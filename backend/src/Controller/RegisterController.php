<?php

namespace App\Controller;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    #[Route('/api/register', name: 'api_register', methods: ['POST'])]
    public function register(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher,
        ValidatorInterface $validator
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $user = new User();
        $user->setFirstname($data['firstName'] ?? '');
        $user->setLastname($data['lastName'] ?? '');
        $user->setEmail($data['email'] ?? '');
        $user->setPlainPassword($data['password'] ?? '');
        $role = strtoupper('ROLE_' . ($data['role'] ?? 'RECRUITER'));
        $user->setRoles([$role]);


        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            return $this->json(['errors' => (string) $errors], 400);
        }

        $hashedPassword = $passwordHasher->hashPassword($user, $user->getPlainPassword());
        $user->setPassword($hashedPassword);
        $user->setPlainPassword(null);

        $em->persist($user);
        $em->flush();

        return $this->json(['message' => 'User registered successfully'], 201);
    }
}
