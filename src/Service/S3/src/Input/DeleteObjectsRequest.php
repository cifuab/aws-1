<?php

namespace AsyncAws\S3\Input;

use AsyncAws\Core\Exception\InvalidArgument;
use AsyncAws\Core\Input;
use AsyncAws\Core\Request;
use AsyncAws\Core\Stream\StreamFactory;
use AsyncAws\S3\Enum\ChecksumAlgorithm;
use AsyncAws\S3\Enum\RequestPayer;
use AsyncAws\S3\ValueObject\Delete;

final class DeleteObjectsRequest extends Input
{
    /**
     * The bucket name containing the objects to delete.
     *
     * **Directory buckets** - When you use this operation with a directory bucket, you must use virtual-hosted-style
     * requests in the format `*Bucket-name*.s3express-*zone-id*.*region-code*.amazonaws.com`. Path-style requests are not
     * supported. Directory bucket names must be unique in the chosen Zone (Availability Zone or Local Zone). Bucket names
     * must follow the format `*bucket-base-name*--*zone-id*--x-s3` (for example,
     * `*amzn-s3-demo-bucket*--*usw2-az1*--x-s3`). For information about bucket naming restrictions, see Directory bucket
     * naming rules [^1] in the *Amazon S3 User Guide*.
     *
     * **Access points** - When you use this action with an access point for general purpose buckets, you must provide the
     * alias of the access point in place of the bucket name or specify the access point ARN. When you use this action with
     * an access point for directory buckets, you must provide the access point name in place of the bucket name. When using
     * the access point ARN, you must direct requests to the access point hostname. The access point hostname takes the form
     * *AccessPointName*-*AccountId*.s3-accesspoint.*Region*.amazonaws.com. When using this action with an access point
     * through the Amazon Web Services SDKs, you provide the access point ARN in place of the bucket name. For more
     * information about access point ARNs, see Using access points [^2] in the *Amazon S3 User Guide*.
     *
     * > Object Lambda access points are not supported by directory buckets.
     *
     * **S3 on Outposts** - When you use this action with S3 on Outposts, you must direct requests to the S3 on Outposts
     * hostname. The S3 on Outposts hostname takes the form
     * `*AccessPointName*-*AccountId*.*outpostID*.s3-outposts.*Region*.amazonaws.com`. When you use this action with S3 on
     * Outposts, the destination bucket must be the Outposts access point ARN or the access point alias. For more
     * information about S3 on Outposts, see What is S3 on Outposts? [^3] in the *Amazon S3 User Guide*.
     *
     * [^1]: https://docs.aws.amazon.com/AmazonS3/latest/userguide/directory-bucket-naming-rules.html
     * [^2]: https://docs.aws.amazon.com/AmazonS3/latest/userguide/using-access-points.html
     * [^3]: https://docs.aws.amazon.com/AmazonS3/latest/userguide/S3onOutposts.html
     *
     * @required
     *
     * @var string|null
     */
    private $bucket;

    /**
     * Container for the request.
     *
     * @required
     *
     * @var Delete|null
     */
    private $delete;

    /**
     * The concatenation of the authentication device's serial number, a space, and the value that is displayed on your
     * authentication device. Required to permanently delete a versioned object if versioning is configured with MFA delete
     * enabled.
     *
     * When performing the `DeleteObjects` operation on an MFA delete enabled bucket, which attempts to delete the specified
     * versioned objects, you must include an MFA token. If you don't provide an MFA token, the entire request will fail,
     * even if there are non-versioned objects that you are trying to delete. If you provide an invalid token, whether there
     * are versioned object keys in the request or not, the entire Multi-Object Delete request will fail. For information
     * about MFA Delete, see MFA Delete [^1] in the *Amazon S3 User Guide*.
     *
     * > This functionality is not supported for directory buckets.
     *
     * [^1]: https://docs.aws.amazon.com/AmazonS3/latest/dev/Versioning.html#MultiFactorAuthenticationDelete
     *
     * @var string|null
     */
    private $mfa;

    /**
     * @var RequestPayer::*|null
     */
    private $requestPayer;

    /**
     * Specifies whether you want to delete this object even if it has a Governance-type Object Lock in place. To use this
     * header, you must have the `s3:BypassGovernanceRetention` permission.
     *
     * > This functionality is not supported for directory buckets.
     *
     * @var bool|null
     */
    private $bypassGovernanceRetention;

    /**
     * The account ID of the expected bucket owner. If the account ID that you provide does not match the actual owner of
     * the bucket, the request fails with the HTTP status code `403 Forbidden` (access denied).
     *
     * @var string|null
     */
    private $expectedBucketOwner;

    /**
     * Indicates the algorithm used to create the checksum for the object when you use the SDK. This header will not provide
     * any additional functionality if you don't use the SDK. When you send this header, there must be a corresponding
     * `x-amz-checksum-*algorithm*` or `x-amz-trailer` header sent. Otherwise, Amazon S3 fails the request with the HTTP
     * status code `400 Bad Request`.
     *
     * For the `x-amz-checksum-*algorithm*` header, replace `*algorithm*` with the supported algorithm from the following
     * list:
     *
     * - `CRC32`
     * - `CRC32C`
     * - `CRC64NVME`
     * - `SHA1`
     * - `SHA256`
     *
     * For more information, see Checking object integrity [^1] in the *Amazon S3 User Guide*.
     *
     * If the individual checksum value you provide through `x-amz-checksum-*algorithm*` doesn't match the checksum
     * algorithm you set through `x-amz-sdk-checksum-algorithm`, Amazon S3 fails the request with a `BadDigest` error.
     *
     * If you provide an individual checksum, Amazon S3 ignores any provided `ChecksumAlgorithm` parameter.
     *
     * [^1]: https://docs.aws.amazon.com/AmazonS3/latest/userguide/checking-object-integrity.html
     *
     * @var ChecksumAlgorithm::*|null
     */
    private $checksumAlgorithm;

    /**
     * @param array{
     *   Bucket?: string,
     *   Delete?: Delete|array,
     *   MFA?: null|string,
     *   RequestPayer?: null|RequestPayer::*,
     *   BypassGovernanceRetention?: null|bool,
     *   ExpectedBucketOwner?: null|string,
     *   ChecksumAlgorithm?: null|ChecksumAlgorithm::*,
     *   '@region'?: string|null,
     * } $input
     */
    public function __construct(array $input = [])
    {
        $this->bucket = $input['Bucket'] ?? null;
        $this->delete = isset($input['Delete']) ? Delete::create($input['Delete']) : null;
        $this->mfa = $input['MFA'] ?? null;
        $this->requestPayer = $input['RequestPayer'] ?? null;
        $this->bypassGovernanceRetention = $input['BypassGovernanceRetention'] ?? null;
        $this->expectedBucketOwner = $input['ExpectedBucketOwner'] ?? null;
        $this->checksumAlgorithm = $input['ChecksumAlgorithm'] ?? null;
        parent::__construct($input);
    }

    /**
     * @param array{
     *   Bucket?: string,
     *   Delete?: Delete|array,
     *   MFA?: null|string,
     *   RequestPayer?: null|RequestPayer::*,
     *   BypassGovernanceRetention?: null|bool,
     *   ExpectedBucketOwner?: null|string,
     *   ChecksumAlgorithm?: null|ChecksumAlgorithm::*,
     *   '@region'?: string|null,
     * }|DeleteObjectsRequest $input
     */
    public static function create($input): self
    {
        return $input instanceof self ? $input : new self($input);
    }

    public function getBucket(): ?string
    {
        return $this->bucket;
    }

    public function getBypassGovernanceRetention(): ?bool
    {
        return $this->bypassGovernanceRetention;
    }

    /**
     * @return ChecksumAlgorithm::*|null
     */
    public function getChecksumAlgorithm(): ?string
    {
        return $this->checksumAlgorithm;
    }

    public function getDelete(): ?Delete
    {
        return $this->delete;
    }

    public function getExpectedBucketOwner(): ?string
    {
        return $this->expectedBucketOwner;
    }

    public function getMfa(): ?string
    {
        return $this->mfa;
    }

    /**
     * @return RequestPayer::*|null
     */
    public function getRequestPayer(): ?string
    {
        return $this->requestPayer;
    }

    /**
     * @internal
     */
    public function request(): Request
    {
        // Prepare headers
        $headers = ['content-type' => 'application/xml'];
        if (null !== $this->mfa) {
            $headers['x-amz-mfa'] = $this->mfa;
        }
        if (null !== $this->requestPayer) {
            if (!RequestPayer::exists($this->requestPayer)) {
                throw new InvalidArgument(\sprintf('Invalid parameter "RequestPayer" for "%s". The value "%s" is not a valid "RequestPayer".', __CLASS__, $this->requestPayer));
            }
            $headers['x-amz-request-payer'] = $this->requestPayer;
        }
        if (null !== $this->bypassGovernanceRetention) {
            $headers['x-amz-bypass-governance-retention'] = $this->bypassGovernanceRetention ? 'true' : 'false';
        }
        if (null !== $this->expectedBucketOwner) {
            $headers['x-amz-expected-bucket-owner'] = $this->expectedBucketOwner;
        }
        if (null !== $this->checksumAlgorithm) {
            if (!ChecksumAlgorithm::exists($this->checksumAlgorithm)) {
                throw new InvalidArgument(\sprintf('Invalid parameter "ChecksumAlgorithm" for "%s". The value "%s" is not a valid "ChecksumAlgorithm".', __CLASS__, $this->checksumAlgorithm));
            }
            $headers['x-amz-sdk-checksum-algorithm'] = $this->checksumAlgorithm;
        }

        // Prepare query
        $query = [];

        // Prepare URI
        $uri = [];
        if (null === $v = $this->bucket) {
            throw new InvalidArgument(\sprintf('Missing parameter "Bucket" for "%s". The value cannot be null.', __CLASS__));
        }
        $uri['Bucket'] = $v;
        $uriString = '/' . rawurlencode($uri['Bucket']) . '?delete';

        // Prepare Body

        $document = new \DOMDocument('1.0', 'UTF-8');
        $document->formatOutput = false;
        $this->requestBody($document, $document);
        $body = $document->hasChildNodes() ? $document->saveXML() : '';

        // Return the Request
        return new Request('POST', $uriString, $query, $headers, StreamFactory::create($body));
    }

    public function setBucket(?string $value): self
    {
        $this->bucket = $value;

        return $this;
    }

    public function setBypassGovernanceRetention(?bool $value): self
    {
        $this->bypassGovernanceRetention = $value;

        return $this;
    }

    /**
     * @param ChecksumAlgorithm::*|null $value
     */
    public function setChecksumAlgorithm(?string $value): self
    {
        $this->checksumAlgorithm = $value;

        return $this;
    }

    public function setDelete(?Delete $value): self
    {
        $this->delete = $value;

        return $this;
    }

    public function setExpectedBucketOwner(?string $value): self
    {
        $this->expectedBucketOwner = $value;

        return $this;
    }

    public function setMfa(?string $value): self
    {
        $this->mfa = $value;

        return $this;
    }

    /**
     * @param RequestPayer::*|null $value
     */
    public function setRequestPayer(?string $value): self
    {
        $this->requestPayer = $value;

        return $this;
    }

    private function requestBody(\DOMNode $node, \DOMDocument $document): void
    {
        if (null === $v = $this->delete) {
            throw new InvalidArgument(\sprintf('Missing parameter "Delete" for "%s". The value cannot be null.', __CLASS__));
        }

        $node->appendChild($child = $document->createElement('Delete'));
        $child->setAttribute('xmlns', 'http://s3.amazonaws.com/doc/2006-03-01/');
        $v->requestBody($child, $document);
    }
}
