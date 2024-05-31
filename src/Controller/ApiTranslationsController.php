<?php

namespace App\Controller;

use App\Abstracts\Classes\AbstractController;
use App\Entity\Application;
use App\Services\TranslationsService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/translations')]
class ApiTranslationsController extends AbstractController
{


    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        public readonly TranslationsService $translationsService,
    ) {
    }


    #[Route('/all', name: 'api_translations_all', methods: ['GET'])]
    public function api_translations_all(Request $request): JsonResponse
    {
        /**
         * @var Application $application
         */
        $application = $request->attributes->get('application');

        $translations = $this->translationsService->translationsAll($application);

        return $this->ok($translations);
    }

}
