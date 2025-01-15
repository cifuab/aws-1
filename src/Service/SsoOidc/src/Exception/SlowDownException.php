<?php

namespace AsyncAws\SsoOidc\Exception;

use AsyncAws\Core\Exception\Http\ClientException;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * Indicates that the client is making the request too frequently and is more than the service can handle.
 */
final class SlowDownException extends ClientException
{
    /**
     * Single error code. For this exception the value will be `slow_down`.
     *
     * @var string|null
     */
    private $error;

    /**
     * Human-readable text providing additional information, used to assist the client developer in understanding the error
     * that occurred.
     *
     * @var string|null
     */
    private $error_description;

    public function getError(): ?string
    {
        return $this->error;
    }

    public function getError_description(): ?string
    {
        return $this->error_description;
    }

    protected function populateResult(ResponseInterface $response): void
    {
        $data = $response->toArray(false);

        $this->error = isset($data['error']) ? (string) $data['error'] : null;
        $this->error_description = isset($data['error_description']) ? (string) $data['error_description'] : null;
    }
}