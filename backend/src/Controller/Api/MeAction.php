<?php

namespace App\Controller\Api;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\SerializerInterface;

class MeAction extends AbstractController
{
    public function __invoke(#[CurrentUser()] User $user, SerializerInterface $serializer): JsonResponse
    {
        $data = $serializer->serialize($user, 'json', ['groups' => ['read_user']]);

        return new JsonResponse($data, 200, [], true);
    }
}
