<?php declare(strict_types=1);

namespace App\Abstracts\Classes;

use App\Abstracts\Traits\JsonResponseHelperTrait;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AbstractController
 *
 * @package App\Abstracts\Classes
 * @author  Dmytro Dyvulskyi <dmytro.dyvulskyi@nations-original.com>
 */
class AbstractController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    use JsonResponseHelperTrait;


    protected function getPostData(Request $request): array
    {
        if (json_validate($request->getContent()) === false) {
            return [];
        }

        return json_decode($request->getContent(), true);
    }

}