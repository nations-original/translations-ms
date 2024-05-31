<?php declare(strict_types=1);

namespace App\MessageHandler;

use App\Entity\Application;
use App\Entity\Locale;
use App\Message\TranslationsLocalesAdd;
use App\Services\TranslationsLocalesService;
use App\Services\TranslationsService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Throwable;

#[AsMessageHandler]
final class TranslationsLocalesAddHandler
{

    public function __construct(
        public readonly EntityManagerInterface $entityManager,
        public readonly TranslationsService $translationsService,
        private readonly TranslationsLocalesService $translationsLocalesService,
    ) {
    }


    public function __invoke(TranslationsLocalesAdd $message)
    {
        $app = $this->entityManager
            ->getRepository(Application::class)
            ->find($message->appUuid);

        if (!$app) {
            throw new Exception('Application not found'); // todo:: log error
        }

        // check if locale already exists for this application
        $locale = $this->entityManager
            ->getRepository(Locale::class)
            ->findOneBy([
                'name' => $message->locale,
                'application' => $app,
            ]);

        if ($locale) {
            throw new Exception('locale already exists'); // todo:: log error
        }

        try {
            $this->translationsLocalesService->translationsLocalesAdd($message->locale, $app);

            $this->entityManager->persist($app);
            $this->entityManager->flush();
        } catch (Throwable $e) {
            throw new Exception($e->getMessage()); // todo:: log error
        }
    }
}
