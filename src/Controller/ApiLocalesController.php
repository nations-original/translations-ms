<?php

namespace App\Controller;

use App\Abstracts\Classes\AbstractController;
use App\Entity\Locale;
use App\Services\TranslationsLocalesService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

#[Route('/api/translations/locales')]
class ApiLocalesController extends AbstractController
{

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly TranslationsLocalesService $translationsLocalesService,
    ) {
    }


    #[Route('/add', name: 'api_translations_locales_add', methods: ['POST'])]
    public function api_translations_locales_add(Request $request): JsonResponse
    {
        $app = $request->attributes->get('application');
        $postData = $this->getPostData($request);
        $localeName = $postData['locale'] ?? null;

        if ($localeName === null) {
            return $this->badRequest('locale is required');
        }

        // check if locale already exists for this application
        $locale = $this->entityManager
            ->getRepository(Locale::class)
            ->findOneBy([
                'name' => $localeName,
                'application' => $app,
            ]);

        if ($locale) {
            return $this->badRequest('locale already exists');
        }

        try {
            $this->translationsLocalesService->translationsLocalesAdd($localeName, $app);

            $this->entityManager->persist($app);
            $this->entityManager->flush();
        } catch (Throwable $e) {
            return $this->badRequest($e->getMessage());
        }

        return $this->created();
    }

    #[Route('/set-active', name: 'api_translations_locales_set_active', methods: ['GET'])]
    public function api_translations_locales_set_active(Request $request): JsonResponse
    {
        /**
         * @var Locale $locale
         */
        $locale = $request->attributes->get('locale');

        try {
            $this->translationsLocalesService->translationsLocalesSetActive($locale);

            $this->entityManager->persist($locale);
            $this->entityManager->flush();
        } catch (Throwable $e) {
            return $this->badRequest($e->getMessage());
        }

        return $this->ok('locale activated');
    }

    #[Route('/set-inactive', name: 'api_translations_locales_set_inactive', methods: ['GET'])]
    public function api_translations_locales_set_inactive(Request $request): JsonResponse
    {
        /**
         * @var Locale $locale
         */
        $locale = $request->attributes->get('locale');

        try {
            $this->translationsLocalesService->translationsLocalesSetInactive($locale);

            $this->entityManager->persist($locale);
            $this->entityManager->flush();
        } catch (Throwable $e) {
            return $this->badRequest($e->getMessage());
        }

        return $this->ok('locale deactivated');
    }

}
