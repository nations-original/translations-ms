<?php declare(strict_types=1);

namespace App\MessageHandler;

use App\Entity\Application;
use App\Entity\Locale;
use App\Message\TranslationsLocalesSetInactive;
use App\Services\TranslationsLocalesService;
use App\Services\TranslationsService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Throwable;

#[AsMessageHandler]
final class TranslationsLocalesSetInactiveHandler
{

    public function __construct(
        public readonly EntityManagerInterface $entityManager,
        public readonly TranslationsService $translationsService,
        private readonly TranslationsLocalesService $translationsLocalesService,
    ) {
    }


    public function __invoke(TranslationsLocalesSetInactive $message)
    {
        $app = $this->entityManager
            ->getRepository(Application::class)
            ->find($message->appUuid);

        if (!$app) {
            throw new Exception('Application not found'); // todo:: log error
        }

        // get locale already exists for this application
        $locale = $this->entityManager
            ->getRepository(Locale::class)
            ->findOneBy([
                'name' => $message->locale,
                'application' => $app,
            ]);

        if (!$locale) {
            throw new Exception('locale not found'); // todo:: log error
        }

        try {
            $this->translationsLocalesService->translationsLocalesSetInactive($locale);

            $this->entityManager->persist($app);
            $this->entityManager->flush();
        } catch (Throwable $e) {
            throw new Exception($e->getMessage()); // todo:: log error
        }
    }
}
