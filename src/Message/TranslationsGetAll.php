<?php declare(strict_types=1);

namespace App\Message;

/**
 * Class TranslationsGetAll
 *
 * @package App\Message
 * @author  Dmytro Dyvulskyi <dmytro.dyvulskyi@nations-original.com>
 */
final readonly class TranslationsGetAll
{

    public function __construct(
        public string $messageUuid,
        public string $appUuid,
    ) { }

}
