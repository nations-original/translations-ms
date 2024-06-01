<?php declare(strict_types=1);

namespace App\MessageHandler;

use App\Entity\Application;
use App\Message\TranslationsGetAll;
use App\Message\TranslationsGetAllResponse;
use App\Services\TranslationsService;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
final class TranslationsGetAllHandler
{

    public function __construct(
        public readonly MessageBusInterface $messageBus,
        public readonly EntityManagerInterface $entityManager,
        public readonly TranslationsService $translationsService,
    ) { }


    public function __invoke(TranslationsGetAll $message)
    {
        $app = $this->entityManager
            ->getRepository(Application::class)
            ->find($message->appUuid);

        if (!$app) {
            throw new RuntimeException('Application not found'); // todo:: log error
        }

        /**
         * @throws RuntimeException todo:: log error
         */
        $translations = $this->translationsService->translationsAll($app);

        // send the TranslationsGetAllResponse message
        $this->messageBus->dispatch(new TranslationsGetAllResponse($message->messageUuid, $translations));
    }
}
