<?php

namespace AsyncAws\CognitoIdentityProvider\Result;

use AsyncAws\Core\Response;
use AsyncAws\Core\Result;

class AssociateSoftwareTokenResponse extends Result
{
    /**
     * A unique generated shared secret code that is used by the TOTP algorithm to generate a one-time code.
     *
     * @var string|null
     */
    private $secretCode;

    /**
     * The session identifier that maintains the state of authentication requests and challenge responses.
     *
     * @var string|null
     */
    private $session;

    public function getSecretCode(): ?string
    {
        $this->initialize();

        return $this->secretCode;
    }

    public function getSession(): ?string
    {
        $this->initialize();

        return $this->session;
    }

    protected function populateResult(Response $response): void
    {
        $data = $response->toArray();

        $this->secretCode = isset($data['SecretCode']) ? (string) $data['SecretCode'] : null;
        $this->session = isset($data['Session']) ? (string) $data['Session'] : null;
    }
}
