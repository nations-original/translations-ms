<?php declare(strict_types=1);

namespace App\Services;

use App\Entity\Application;
use RuntimeException;

/**
 * Trait TranslationsTrait
 *
 * @package App\Helpers
 * @author  Dmytro Dyvulskyi <dmytro.dyvulskyi@nations-original.com>
 */
final class TranslationsService
{

    public function translationsAll(Application $application): array
    {
        foreach ($application->getLocales() as $locale) {
            if (!$locale->isActive()) {
                continue;
            }
            $translations[$locale->getName()] = [];

            foreach ($locale->getTranslations() as $translation) {
                $translations[$locale->getName()][$translation->getString()] = $translation->getTranslation();
            }
        }

        if (!isset($translations)) {
            throw new RuntimeException('No active locales found for the application');
        }

        return $translations;
    }

}