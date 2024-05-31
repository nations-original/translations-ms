<?php declare(strict_types=1);

namespace App\Services;

use App\Entity\Application;

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

            foreach ($locale->getTranslations() as $translation) {
                $translations[$locale->getName()][$translation->getString()] = [
                    'translation' => $translation->getTranslation(),
                    'translation_male' => $translation->getTranslationMale(),
                    'translation_female' => $translation->getTranslationFemale(),
                    'translation_one' => $translation->getTranslationOne(),
                    'translation_few' => $translation->getTranslationFew(),
                    'translation_many' => $translation->getTranslationMany(),
                ];
            }
        }

        return $translations;
    }

}