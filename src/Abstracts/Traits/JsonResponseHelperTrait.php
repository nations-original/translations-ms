<?php declare(strict_types=1);

namespace App\Abstracts\Traits;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Trait JsonResponseHelperTrait
 *
 * Provides convenient methods for returning standardized JSON responses in a Symfony application.
 * Each method corresponds to a specific HTTP status code, encapsulating the creation of
 * JsonResponse objects with appropriate status and headers.
 *
 * @package App\Abstracts\Traits
 * @author  Dmytro Dyvulskyi <dmytro.dyvulskyi@nations-original.com>
 */
trait JsonResponseHelperTrait
{
    /**
     * Generic method to create a JsonResponse.
     *
     * @param mixed|null $data    The data to be returned in the response. Can be of any type.
     * @param int        $status  HTTP status code for the response.
     * @param array      $headers Additional headers to include in the response.
     * @param bool       $json    Indicates if the provided data is already a JSON string.
     *
     * @return JsonResponse Returns a JsonResponse object.
     */
    protected function json(mixed $data, int $status = 200, array $headers = [], array $context = []): JsonResponse
    {
        if ($context !== []) {
            throw new Exception('Context is not implemented!');
        }

        return new JsonResponse(data: $data, status: $status, headers: $headers, json: false);
    }

    /**
     * Shortcut to return a 200 OK response.
     *
     * @param mixed|null $data    The response data.
     * @param array      $headers Additional headers for the response.
     *
     * @return JsonResponse Returns a 200 OK JsonResponse.
     */
    protected function ok(mixed $data = null, array $headers = []): JsonResponse
    {
        if (is_string($data)) {
            $data = ['message' => $data];
        }

        return $this->json(data: $data, status: JsonResponse::HTTP_OK, headers: $headers);
    }

    /**
     * Shortcut to return a 201 Created response.
     *
     * @param mixed|null $data    The response data.
     * @param array      $headers Additional headers for the response.
     *
     * @return JsonResponse Returns a 201 Created JsonResponse.
     */
    protected function created(mixed $data = null, array $headers = []): JsonResponse
    {
        if (is_string($data)) {
            $data = ['message' => $data];
        }

        return $this->json(data: $data, status: JsonResponse::HTTP_CREATED, headers: $headers);
    }

    /**
     * Shortcut to return a 202 Accepted response.
     *
     * @param mixed|null $data    The response data.
     * @param array      $headers Additional headers for the response.
     *
     * @return JsonResponse Returns a 202 Accepted JsonResponse.
     */
    protected function accepted(mixed $data = null, array $headers = []): JsonResponse
    {
        if (is_string($data)) {
            $data = ['message' => $data];
        }

        return $this->json(data: $data, status: JsonResponse::HTTP_ACCEPTED, headers: $headers);
    }

    /**
     * Shortcut to return a 204 No Content response.
     *
     * @param array $headers Additional headers for the response.
     *
     * @return JsonResponse Returns a 204 No Content JsonResponse.
     */
    protected function noContent(array $headers = []): JsonResponse
    {
        return $this->json('', status: JsonResponse::HTTP_NO_CONTENT, headers: $headers);
    }

    /**
     * Shortcut to return a 400 Bad Request response.
     *
     * @param mixed|null $data    The response data.
     * @param array      $headers Additional headers for the response.
     *
     * @return JsonResponse Returns a 400 Bad Request JsonResponse.
     */
    protected function badRequest(mixed $data = null, array $headers = []): JsonResponse
    {
        if (is_string($data)) {
            $data = ['error' => $data];
        }

        return $this->json(data: $data, status: JsonResponse::HTTP_BAD_REQUEST, headers: $headers);
    }

    /**
     * Shortcut to return a 401 Unauthorized response.
     *
     * @param mixed|null $data    The response data.
     * @param array      $headers Additional headers for the response.
     *
     * @return JsonResponse Returns a 401 Unauthorized JsonResponse.
     */
    protected function unauthorized(mixed $data = null, array $headers = []): JsonResponse
    {
        if (is_string($data)) {
            $data = ['error' => $data];
        }

        return $this->json(data: $data, status: JsonResponse::HTTP_UNAUTHORIZED, headers: $headers);
    }

    /**
     * Shortcut to return a 403 Forbidden response.
     *
     * @param mixed|null $data    The response data.
     * @param array      $headers Additional headers for the response.
     *
     * @return JsonResponse Returns a 403 Forbidden JsonResponse.
     */
    protected function forbidden(mixed $data = null, array $headers = []): JsonResponse
    {
        if (is_string($data)) {
            $data = ['error' => $data];
        }

        return $this->json(data: $data, status: JsonResponse::HTTP_FORBIDDEN, headers: $headers);
    }

    /**
     * Shortcut to return a 404 Not Found response.
     *
     * @param mixed|null $data    The response data.
     * @param array      $headers Additional headers for the response.
     *
     * @return JsonResponse Returns a 404 Not Found JsonResponse.
     */
    protected function notFound(mixed $data = null, array $headers = []): JsonResponse
    {
        if (is_string($data)) {
            $data = ['error' => $data];
        }

        return $this->json(data: $data, status: JsonResponse::HTTP_NOT_FOUND, headers: $headers);
    }

    /**
     * Shortcut to return a 406 Not Acceptable response.
     *
     * @param mixed|null $data    The response data.
     * @param array      $headers Additional headers for the response.
     *
     * @return JsonResponse Returns a 406 Not Acceptable JsonResponse.
     */
    protected function notAcceptable(mixed $data = null, array $headers = []): JsonResponse
    {
        if (is_string($data)) {
            $data = ['error' => $data];
        }

        return $this->json(data: $data, status: JsonResponse::HTTP_NOT_ACCEPTABLE, headers: $headers);
    }

    /**
     * Shortcut to return a 422 Unprocessable Entity response.
     *
     * @param mixed|null $data    The response data.
     * @param array      $headers Additional headers for the response.
     *
     * @return JsonResponse Returns a 422 Unprocessable Entity JsonResponse.
     */
    protected function unprocessableEntity(mixed $data = null, array $headers = []): JsonResponse
    {
        if (is_string($data)) {
            $data = ['error' => $data];
        }

        return $this->json(data: $data, status: JsonResponse::HTTP_UNPROCESSABLE_ENTITY, headers: $headers);
    }

}
