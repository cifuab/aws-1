
# Configuration

There are some configuration you can pass to an API client. Use an instance of the
`Configuration` class or a plain array.

```php
use AsyncAws\Sqs\SqsClient;
use AsyncAws\Core\Configuration;

$config = Configuration::create([
    'region' => 'eu-central-1',
]);
$sqs = new SqsClient($config);

// Or with an array
$sqs = new SqsClient([
    'region' => 'eu-central-1',
]);
```

## Configuration reference

Below is a list of all supported configuration keys, their default value and what
they are used for.

### region

**Default:** 'us-east-1'

The AWS region the client should be targeting.

> **Note**: Region can also be defined by providing a `@region` parameter in
> operation's input

### debug

**Default:** 'false'

When this is set to `true` we will write the full HTTP request and response as
an `debug` log entry. Make sure you pass a logger to the `Client`.

> **Note**: This will have an negative impact on performance.

### profile

**Default:** 'default'

The name of the AWS Profile configured when using [credential and configuration files](/authentication/credentials-file.md)
for authentication.

### accessKeyId

The AWS access key id used for authentication.

### accessKeySecret

The AWS access key secret used for authentication.

### sessionToken

The AWS session token passed alongside temporary credentials.

See [AWS documentation](https://docs.aws.amazon.com/IAM/latest/UserGuide/id_credentials_temp_use-resources.html)
and [CLI reference](https://docs.aws.amazon.com/cli/latest/reference/sts/get-session-token.html)
for more information.

### sharedCredentialsFile

**Default:** '~/.aws/credentials'

The credentials file to look in when using [credential and configuration files](/authentication/credentials-file.md)
for authentication.

### sharedConfigFile

**Default:** '~/.aws/config'

The config file to look in when using [credential and configuration files](/authentication/credentials-file.md)
for authentication.

### endpoint

**Default:** 'https://%service%.%region%.amazonaws.com'

### roleArn

The Amazon Resource Name (ARN) of the role that the client should be "assuming" after authentication.

### webIdentityTokenFile

Path to the file that contains the OAuth 2.0 access token when using the [WebIdentity Provider](/authentication/web-identity.md)

### roleSessionName

**Default:** 'async-aws-' followed by random chars

An identifier for the assumed role session

### containerCredentialsRelativeUri

The relative path that is used to fetch credentials inside and ECS instance.
See [IAM Roles for Tasks](https://docs.aws.amazon.com/AmazonECS/latest/developerguide/task-iam-roles.html) for more information.

### endpointDiscoveryEnabled

**Default:** 'false'

Enable the endpoint discovery when the operation support it
See [Endpoint discovery](https://docs.aws.amazon.com/sdkref/latest/guide/feature-endpoint-discovery.html) for more information.

### podIdentityCredentialsFullUri

Full Uri to the endpoint of the Pod Identity agent, which should already be injected by the Pod Identity agent when using the [PodIdentity Provider](/authentication/pod-identity.md)

### podIdentityAuthorizationTokenFile

Path to the file that contains the Pod Identity access token, which should already be injected by the Pod Identity agent when using the [PodIdentity Provider](/authentication/pod-identity.md)

## S3 specific Configuration reference

### pathStyleEndpoint

**Default:** 'false'

Set to true to send requests to an S3 path style endpoint by default.
See [Virtual Hosting of Buckets](https://docs.aws.amazon.com/AmazonS3/latest/dev/VirtualHosting.html) about path style vs virtual host style.

### sendChunkedBody

**Default:** 'false'

Set to true to send requests in multiple chunks. This prevents reading the file
twice to calculate the signature, but is not always allowed by Non-AWS S3
endpoints.
