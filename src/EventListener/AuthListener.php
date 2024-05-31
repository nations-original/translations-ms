<?php

namespace App\EventListener;

use App\Entity\Application;
use App\Entity\Locale;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class AuthListener
{

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }


    #[AsEventListener(event: KernelEvents::REQUEST)]
    public function onKernelRequest(RequestEvent $event): void
    {
        if ($event->getRequest()->attributes->get('_route') === null) {
            return;
        }

        $this->authenticate($event);
        $this->setDefaultLanguage($event);
    }

    private function authenticate(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $request->headers->get('Authorization');

        // if the current route is "app_api_authorization"
        if ($request->attributes->get('_route') === 'app_api_authorization') {
            return;
        }

        // if the Authorization header is not set, then return 401 Unauthorized
        if (!$request->headers->has('Authorization')) {
            $event->setResponse(new JsonResponse(['error' => 'Unauthorized'], JsonResponse::HTTP_UNAUTHORIZED));
        }

        // check if application with uuid from Authorization header exists
        $application = $this->entityManager
            ->getRepository(Application::class)
            ->find($request->headers->get('Authorization'));

        // if application not found, then return 403 Forbidden
        if (!$application) {
            $event->setResponse(new JsonResponse(['error' => 'Forbidden'], JsonResponse::HTTP_FORBIDDEN));
        }

        // if application is not active, then return 403 Forbidden
        if (!$application->isActive()) {
            $event->setResponse(new JsonResponse(['error' => 'Forbidden'], JsonResponse::HTTP_FORBIDDEN));
        }

        // set the application to the request attributes
        $request->attributes->set('application', $application);
    }

    private function setDefaultLanguage(RequestEvent $event): void
    {
        $route = $event->getRequest()->attributes->get('_route');

        // if route is "app_api_translations_add_locale" then remove "Accept-Language" header and return
        if ($route === 'api_translations_all' || $route === 'api_translations_locales_add') {
            $event->getRequest()->headers->remove('Accept-Language');

            return;
        }

        // get "Accept-Language" header from the request
        $acceptLanguage = $event->getRequest()->headers->get('Accept-Language');


        // get application from the request attributes
        $application = $event->getRequest()->attributes->get('application');

        // if application is set
        if ($application) {
            // if locale is set
            if ($acceptLanguage) {
                // check if the application has the locale
                $checkLocale = $this->entityManager
                    ->getRepository(Locale::class)
                    ->findOneBy(['application' => $application, 'name' => $acceptLanguage]);

                // if locale is not found, return 406 Not Acceptable
                if (!$checkLocale) {
                    $event->setResponse(
                        new JsonResponse(['error' => 'Not Acceptable. Locale not found.'],
                            JsonResponse::HTTP_NOT_ACCEPTABLE)
                    );
                }#else

                // set the locale to the request attributes
                $event->getRequest()->attributes->set('locale', $checkLocale);

                return;
            }

            // if locale is not set, return 406 Not Acceptable
            $event->setResponse(
                new JsonResponse(['error' => 'Not Acceptable. Locale not set.'], JsonResponse::HTTP_NOT_ACCEPTABLE)
            );
        }
    }
}
