<?php

namespace AsyncAws\S3\ValueObject;

use AsyncAws\Core\Exception\InvalidArgument;
use AsyncAws\S3\Enum\BucketLocationConstraint;

/**
 * The configuration information for the bucket.
 */
final class CreateBucketConfiguration
{
    /**
     * Specifies the Region where the bucket will be created. You might choose a Region to optimize latency, minimize costs,
     * or address regulatory requirements. For example, if you reside in Europe, you will probably find it advantageous to
     * create buckets in the Europe (Ireland) Region.
     *
     * If you don't specify a Region, the bucket is created in the US East (N. Virginia) Region (us-east-1) by default.
     * Configurations using the value `EU` will create a bucket in `eu-west-1`.
     *
     * For a list of the valid values for all of the Amazon Web Services Regions, see Regions and Endpoints [^1].
     *
     * > This functionality is not supported for directory buckets.
     *
     * [^1]: https://docs.aws.amazon.com/general/latest/gr/rande.html#s3_region
     *
     * @var BucketLocationConstraint::*|null
     */
    private $locationConstraint;

    /**
     * Specifies the location where the bucket will be created.
     *
     * **Directory buckets ** - The location type is Availability Zone or Local Zone. To use the Local Zone location type,
     * your account must be enabled for Local Zones. Otherwise, you get an HTTP `403 Forbidden` error with the error code
     * `AccessDenied`. To learn more, see Enable accounts for Local Zones [^1] in the *Amazon S3 User Guide*.
     *
     * > This functionality is only supported by directory buckets.
     *
     * [^1]: https://docs.aws.amazon.com/AmazonS3/latest/userguide/opt-in-directory-bucket-lz.html
     *
     * @var LocationInfo|null
     */
    private $location;

    /**
     * Specifies the information about the bucket that will be created.
     *
     * > This functionality is only supported by directory buckets.
     *
     * @var BucketInfo|null
     */
    private $bucket;

    /**
     * An array of tags that you can apply to the bucket that you're creating. Tags are key-value pairs of metadata used to
     * categorize and organize your buckets, track costs, and control access.
     *
     * > This parameter is only supported for S3 directory buckets. For more information, see Using tags with directory
     * > buckets [^1].
     *
     * [^1]: https://docs.aws.amazon.com/AmazonS3/latest/userguide/directory-buckets-tagging.html
     *
     * @var Tag[]|null
     */
    private $tags;

    /**
     * @param array{
     *   LocationConstraint?: null|BucketLocationConstraint::*,
     *   Location?: null|LocationInfo|array,
     *   Bucket?: null|BucketInfo|array,
     *   Tags?: null|array<Tag|array>,
     * } $input
     */
    public function __construct(array $input)
    {
        $this->locationConstraint = $input['LocationConstraint'] ?? null;
        $this->location = isset($input['Location']) ? LocationInfo::create($input['Location']) : null;
        $this->bucket = isset($input['Bucket']) ? BucketInfo::create($input['Bucket']) : null;
        $this->tags = isset($input['Tags']) ? array_map([Tag::class, 'create'], $input['Tags']) : null;
    }

    /**
     * @param array{
     *   LocationConstraint?: null|BucketLocationConstraint::*,
     *   Location?: null|LocationInfo|array,
     *   Bucket?: null|BucketInfo|array,
     *   Tags?: null|array<Tag|array>,
     * }|CreateBucketConfiguration $input
     */
    public static function create($input): self
    {
        return $input instanceof self ? $input : new self($input);
    }

    public function getBucket(): ?BucketInfo
    {
        return $this->bucket;
    }

    public function getLocation(): ?LocationInfo
    {
        return $this->location;
    }

    /**
     * @return BucketLocationConstraint::*|null
     */
    public function getLocationConstraint(): ?string
    {
        return $this->locationConstraint;
    }

    /**
     * @return Tag[]
     */
    public function getTags(): array
    {
        return $this->tags ?? [];
    }

    /**
     * @internal
     */
    public function requestBody(\DOMElement $node, \DOMDocument $document): void
    {
        if (null !== $v = $this->locationConstraint) {
            if (!BucketLocationConstraint::exists($v)) {
                throw new InvalidArgument(\sprintf('Invalid parameter "LocationConstraint" for "%s". The value "%s" is not a valid "BucketLocationConstraint".', __CLASS__, $v));
            }
            $node->appendChild($document->createElement('LocationConstraint', $v));
        }
        if (null !== $v = $this->location) {
            $node->appendChild($child = $document->createElement('Location'));

            $v->requestBody($child, $document);
        }
        if (null !== $v = $this->bucket) {
            $node->appendChild($child = $document->createElement('Bucket'));

            $v->requestBody($child, $document);
        }
        if (null !== $v = $this->tags) {
            $node->appendChild($nodeList = $document->createElement('Tags'));
            foreach ($v as $item) {
                $nodeList->appendChild($child = $document->createElement('Tag'));

                $item->requestBody($child, $document);
            }
        }
    }
}
