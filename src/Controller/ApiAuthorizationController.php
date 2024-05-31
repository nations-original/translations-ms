<?php

namespace App\Controller;

use App\Abstracts\Classes\AbstractController;
use App\Entity\Application;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ApiAuthorizationController extends AbstractController
{

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) { }


    #[Route('/api/auth', name: 'app_api_authorization', methods: ['POST'])]
    public function app_api_authorization(Request $request): JsonResponse
    {
        $postData = $this->getPostData($request);
        $name = $postData['name'] ?? null;
        $password = $postData['password'] ?? null;

        if ($name === null || $password === null) {
            return $this->badRequest('name and password are required');
        }

        $app = $this->entityManager
            ->getRepository(Application::class)
            ->findOneBy(compact('name'));

        if ($app === null) {
            return $this->unauthorized('Application not found');
        }

        // validate password
        if (!password_verify($password, $app->getPassword())) {
            return $this->unauthorized('Invalid password');
        }

        // return uuid
        return $this->ok(['uuid' => $app->getUuid()]);
    }
}
