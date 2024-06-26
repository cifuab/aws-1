<?php

namespace AsyncAws\Sqs\Tests\Unit\Input;

use AsyncAws\Core\Test\TestCase;
use AsyncAws\Sqs\Input\DeleteQueueRequest;

class DeleteQueueRequestTest extends TestCase
{
    public function testRequest(): void
    {
        $input = new DeleteQueueRequest([
            'QueueUrl' => 'queueUrl',
        ]);

        /** @see https://docs.aws.amazon.com/AWSSimpleQueueService/latest/APIReference/API_DeleteQueue.html */
        $expected = '
            POST / HTTP/1.0
            Content-Type: application/x-amz-json-1.0
            x-amz-target: AmazonSQS.DeleteQueue
            Accept: application/json

            {
                "QueueUrl":"queueUrl"
            }';

        self::assertRequestEqualsHttpRequest($expected, $input->request());
    }
}
