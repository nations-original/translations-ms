<?php declare(strict_types=1);

namespace App\Message;

/**
 * Class TranslationsLocalesSetInactive
 *
 * @package App\Message
 * @author  Dmytro Dyvulskyi <dmytro.dyvulskyi@nations-original.com>
 */
final readonly class TranslationsLocalesSetInactive
{

    public function __construct(
        public string $messageUuid,
        public string $appUuid,
        public string $locale
    ) {
    }

}
