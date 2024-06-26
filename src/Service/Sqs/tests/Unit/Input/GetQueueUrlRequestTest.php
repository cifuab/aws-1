<?php

namespace AsyncAws\Sqs\Tests\Unit\Input;

use AsyncAws\Core\Test\TestCase;
use AsyncAws\Sqs\Input\GetQueueUrlRequest;

class GetQueueUrlRequestTest extends TestCase
{
    public function testRequest(): void
    {
        $input = new GetQueueUrlRequest([
            'QueueName' => 'MyQueue',
            'QueueOwnerAWSAccountId' => '123456',
        ]);

        /** @see https://docs.aws.amazon.com/AWSSimpleQueueService/latest/APIReference/API_GetQueueUrl.html */
        $expected = '
            POST / HTTP/1.0
            Content-Type: application/x-amz-json-1.0
            x-amz-target: AmazonSQS.GetQueueUrl
            Accept: application/json

            {
                "QueueName": "MyQueue",
                "QueueOwnerAWSAccountId": "123456"
            }';

        self::assertRequestEqualsHttpRequest($expected, $input->request());
    }
}
