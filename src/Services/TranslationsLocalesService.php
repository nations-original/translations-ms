<?php declare(strict_types=1);

namespace App\Services;

use App\Entity\Application;
use App\Entity\Locale;

/**
 * Class TranslationsLocalesService
 *
 * @package App\Services
 * @author  Dmytro Dyvulskyi <dmytro.dyvulskyi@nations-original.com>
 */
final class TranslationsLocalesService
{

    public function translationsLocalesAdd(string $localeName, Application $application): void
    {
        $application->addLocale(
            (new Locale())
                ->setName($localeName)
                ->setApplication($application)
        );
    }

    public function translationsLocalesSetActive(Locale $locale): void
    {
        $locale->setActive(true);
    }

    public function translationsLocalesSetInactive(Locale $locale): void
    {
        $locale->setActive(false);
    }

}