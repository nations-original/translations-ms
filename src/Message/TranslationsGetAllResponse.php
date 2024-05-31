<?php declare(strict_types=1);

namespace App\Message;

/**
 * Class TranslationsGetAllResponse
 *
 * @package App\Message
 * @author  Dmytro Dyvulskyi <dmytro.dyvulskyi@nations-original.com>
 */
final readonly class TranslationsGetAllResponse
{

    public function __construct(
        public string $messageUuid,
        public array $translations,
    ) { }

}
