<?php

namespace AsyncAws\CognitoIdentityProvider\Input;

use AsyncAws\CognitoIdentityProvider\ValueObject\AnalyticsMetadataType;
use AsyncAws\CognitoIdentityProvider\ValueObject\AttributeType;
use AsyncAws\CognitoIdentityProvider\ValueObject\UserContextDataType;
use AsyncAws\Core\Exception\InvalidArgument;
use AsyncAws\Core\Input;
use AsyncAws\Core\Request;
use AsyncAws\Core\Stream\StreamFactory;

/**
 * Represents the request to register a user.
 */
final class SignUpRequest extends Input
{
    /**
     * The ID of the app client where the user wants to sign up.
     *
     * @required
     *
     * @var string|null
     */
    private $clientId;

    /**
     * A keyed-hash message authentication code (HMAC) calculated using the secret key of a user pool client and username
     * plus the client ID in the message. For more information about `SecretHash`, see Computing secret hash values [^1].
     *
     * [^1]: https://docs.aws.amazon.com/cognito/latest/developerguide/signing-up-users-in-your-app.html#cognito-user-pools-computing-secret-hash
     *
     * @var string|null
     */
    private $secretHash;

    /**
     * The username of the user that you want to sign up. The value of this parameter is typically a username, but can be
     * any alias attribute in your user pool.
     *
     * @required
     *
     * @var string|null
     */
    private $username;

    /**
     * The user's proposed password. The password must comply with the password requirements [^1] of your user pool.
     *
     * Users can sign up without a password when your user pool supports passwordless sign-in with email or SMS OTPs. To
     * create a user with no password, omit this parameter or submit a blank value. You can only create a passwordless user
     * when passwordless sign-in is available.
     *
     * [^1]: https://docs.aws.amazon.com/cognito/latest/developerguide/managing-users-passwords.html
     *
     * @var string|null
     */
    private $password;

    /**
     * An array of name-value pairs representing user attributes.
     *
     * For custom attributes, include a `custom:` prefix in the attribute name, for example `custom:department`.
     *
     * @var AttributeType[]|null
     */
    private $userAttributes;

    /**
     * Temporary user attributes that contribute to the outcomes of your pre sign-up Lambda trigger. This set of key-value
     * pairs are for custom validation of information that you collect from your users but don't need to retain.
     *
     * Your Lambda function can analyze this additional data and act on it. Your function can automatically confirm and
     * verify select users or perform external API operations like logging user attributes and validation data to Amazon
     * CloudWatch Logs.
     *
     * For more information about the pre sign-up Lambda trigger, see Pre sign-up Lambda trigger [^1].
     *
     * [^1]: https://docs.aws.amazon.com/cognito/latest/developerguide/user-pool-lambda-pre-sign-up.html
     *
     * @var AttributeType[]|null
     */
    private $validationData;

    /**
     * Information that supports analytics outcomes with Amazon Pinpoint, including the user's endpoint ID. The endpoint ID
     * is a destination for Amazon Pinpoint push notifications, for example a device identifier, email address, or phone
     * number.
     *
     * @var AnalyticsMetadataType|null
     */
    private $analyticsMetadata;

    /**
     * Contextual data about your user session like the device fingerprint, IP address, or location. Amazon Cognito threat
     * protection evaluates the risk of an authentication event based on the context that your app generates and passes to
     * Amazon Cognito when it makes API requests.
     *
     * For more information, see Collecting data for threat protection in applications [^1].
     *
     * [^1]: https://docs.aws.amazon.com/cognito/latest/developerguide/user-pool-settings-viewing-threat-protection-app.html
     *
     * @var UserContextDataType|null
     */
    private $userContextData;

    /**
     * A map of custom key-value pairs that you can provide as input for any custom workflows that this action triggers.
     *
     * You create custom workflows by assigning Lambda functions to user pool triggers. When you use the SignUp API action,
     * Amazon Cognito invokes any functions that are assigned to the following triggers: *pre sign-up*, *custom message*,
     * and *post confirmation*. When Amazon Cognito invokes any of these functions, it passes a JSON payload, which the
     * function receives as input. This payload contains a `clientMetadata` attribute, which provides the data that you
     * assigned to the ClientMetadata parameter in your SignUp request. In your function code in Lambda, you can process the
     * `clientMetadata` value to enhance your workflow for your specific needs.
     *
     * For more information, see Using Lambda triggers [^1] in the *Amazon Cognito Developer Guide*.
     *
     * > When you use the `ClientMetadata` parameter, note that Amazon Cognito won't do the following:
     * >
     * > - Store the `ClientMetadata` value. This data is available only to Lambda triggers that are assigned to a user pool
     * >   to support custom workflows. If your user pool configuration doesn't include triggers, the `ClientMetadata`
     * >   parameter serves no purpose.
     * > - Validate the `ClientMetadata` value.
     * > - Encrypt the `ClientMetadata` value. Don't send sensitive information in this parameter.
     * >
     *
     * [^1]: https://docs.aws.amazon.com/cognito/latest/developerguide/cognito-user-identity-pools-working-with-aws-lambda-triggers.html
     *
     * @var array<string, string>|null
     */
    private $clientMetadata;

    /**
     * @param array{
     *   ClientId?: string,
     *   SecretHash?: null|string,
     *   Username?: string,
     *   Password?: null|string,
     *   UserAttributes?: null|array<AttributeType|array>,
     *   ValidationData?: null|array<AttributeType|array>,
     *   AnalyticsMetadata?: null|AnalyticsMetadataType|array,
     *   UserContextData?: null|UserContextDataType|array,
     *   ClientMetadata?: null|array<string, string>,
     *   '@region'?: string|null,
     * } $input
     */
    public function __construct(array $input = [])
    {
        $this->clientId = $input['ClientId'] ?? null;
        $this->secretHash = $input['SecretHash'] ?? null;
        $this->username = $input['Username'] ?? null;
        $this->password = $input['Password'] ?? null;
        $this->userAttributes = isset($input['UserAttributes']) ? array_map([AttributeType::class, 'create'], $input['UserAttributes']) : null;
        $this->validationData = isset($input['ValidationData']) ? array_map([AttributeType::class, 'create'], $input['ValidationData']) : null;
        $this->analyticsMetadata = isset($input['AnalyticsMetadata']) ? AnalyticsMetadataType::create($input['AnalyticsMetadata']) : null;
        $this->userContextData = isset($input['UserContextData']) ? UserContextDataType::create($input['UserContextData']) : null;
        $this->clientMetadata = $input['ClientMetadata'] ?? null;
        parent::__construct($input);
    }

    /**
     * @param array{
     *   ClientId?: string,
     *   SecretHash?: null|string,
     *   Username?: string,
     *   Password?: null|string,
     *   UserAttributes?: null|array<AttributeType|array>,
     *   ValidationData?: null|array<AttributeType|array>,
     *   AnalyticsMetadata?: null|AnalyticsMetadataType|array,
     *   UserContextData?: null|UserContextDataType|array,
     *   ClientMetadata?: null|array<string, string>,
     *   '@region'?: string|null,
     * }|SignUpRequest $input
     */
    public static function create($input): self
    {
        return $input instanceof self ? $input : new self($input);
    }

    public function getAnalyticsMetadata(): ?AnalyticsMetadataType
    {
        return $this->analyticsMetadata;
    }

    public function getClientId(): ?string
    {
        return $this->clientId;
    }

    /**
     * @return array<string, string>
     */
    public function getClientMetadata(): array
    {
        return $this->clientMetadata ?? [];
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getSecretHash(): ?string
    {
        return $this->secretHash;
    }

    /**
     * @return AttributeType[]
     */
    public function getUserAttributes(): array
    {
        return $this->userAttributes ?? [];
    }

    public function getUserContextData(): ?UserContextDataType
    {
        return $this->userContextData;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @return AttributeType[]
     */
    public function getValidationData(): array
    {
        return $this->validationData ?? [];
    }

    /**
     * @internal
     */
    public function request(): Request
    {
        // Prepare headers
        $headers = [
            'Content-Type' => 'application/x-amz-json-1.1',
            'X-Amz-Target' => 'AWSCognitoIdentityProviderService.SignUp',
            'Accept' => 'application/json',
        ];

        // Prepare query
        $query = [];

        // Prepare URI
        $uriString = '/';

        // Prepare Body
        $bodyPayload = $this->requestBody();
        $body = empty($bodyPayload) ? '{}' : json_encode($bodyPayload, 4194304);

        // Return the Request
        return new Request('POST', $uriString, $query, $headers, StreamFactory::create($body));
    }

    public function setAnalyticsMetadata(?AnalyticsMetadataType $value): self
    {
        $this->analyticsMetadata = $value;

        return $this;
    }

    public function setClientId(?string $value): self
    {
        $this->clientId = $value;

        return $this;
    }

    /**
     * @param array<string, string> $value
     */
    public function setClientMetadata(array $value): self
    {
        $this->clientMetadata = $value;

        return $this;
    }

    public function setPassword(?string $value): self
    {
        $this->password = $value;

        return $this;
    }

    public function setSecretHash(?string $value): self
    {
        $this->secretHash = $value;

        return $this;
    }

    /**
     * @param AttributeType[] $value
     */
    public function setUserAttributes(array $value): self
    {
        $this->userAttributes = $value;

        return $this;
    }

    public function setUserContextData(?UserContextDataType $value): self
    {
        $this->userContextData = $value;

        return $this;
    }

    public function setUsername(?string $value): self
    {
        $this->username = $value;

        return $this;
    }

    /**
     * @param AttributeType[] $value
     */
    public function setValidationData(array $value): self
    {
        $this->validationData = $value;

        return $this;
    }

    private function requestBody(): array
    {
        $payload = [];
        if (null === $v = $this->clientId) {
            throw new InvalidArgument(\sprintf('Missing parameter "ClientId" for "%s". The value cannot be null.', __CLASS__));
        }
        $payload['ClientId'] = $v;
        if (null !== $v = $this->secretHash) {
            $payload['SecretHash'] = $v;
        }
        if (null === $v = $this->username) {
            throw new InvalidArgument(\sprintf('Missing parameter "Username" for "%s". The value cannot be null.', __CLASS__));
        }
        $payload['Username'] = $v;
        if (null !== $v = $this->password) {
            $payload['Password'] = $v;
        }
        if (null !== $v = $this->userAttributes) {
            $index = -1;
            $payload['UserAttributes'] = [];
            foreach ($v as $listValue) {
                ++$index;
                $payload['UserAttributes'][$index] = $listValue->requestBody();
            }
        }
        if (null !== $v = $this->validationData) {
            $index = -1;
            $payload['ValidationData'] = [];
            foreach ($v as $listValue) {
                ++$index;
                $payload['ValidationData'][$index] = $listValue->requestBody();
            }
        }
        if (null !== $v = $this->analyticsMetadata) {
            $payload['AnalyticsMetadata'] = $v->requestBody();
        }
        if (null !== $v = $this->userContextData) {
            $payload['UserContextData'] = $v->requestBody();
        }
        if (null !== $v = $this->clientMetadata) {
            if (empty($v)) {
                $payload['ClientMetadata'] = new \stdClass();
            } else {
                $payload['ClientMetadata'] = [];
                foreach ($v as $name => $mv) {
                    $payload['ClientMetadata'][$name] = $mv;
                }
            }
        }

        return $payload;
    }
}
