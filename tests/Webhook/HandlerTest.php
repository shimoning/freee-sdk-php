<?php

namespace Tests\Webhook;

use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Shimoning\FreeeSdk\Webhook\Handler;
use Shimoning\FreeeSdk\Webhook\Domains\Common\Entities\Event;
use Shimoning\FreeeSdk\Webhook\Utilities\VerificationToken;
use Shimoning\FreeeSdk\Webhook\Exceptions\InvalidVerificationTokenException;

class HandlerTest extends TestCase
{
    protected function setUp(): void
    {
        // 初期化処理
        $_SERVER = [];
    }

    public function testHandleWithValidTokenAndJsonPayload(): void
    {
        // Arrange
        $verificationToken = 'valid_token';
        $payload           = json_encode([
            'id'                  => '123',
            'application_id'      => 456,
            'resource'            => 'accounting:expense_application',
            'action'              => 'created',
            'created_at'          => '2023-10-01T00:00:00Z',
            'expense_application' => [
                'id'           => 1,
                'company_id'   => 2,
                'status'       => 'draft',
                'applicant_id' => 3,
            ],
        ]);

        // mock
        $this->setVerificationToken($verificationToken);
        $mockLogger = $this->mockLogger();

        // Act
        $handler = new Handler($verificationToken, $mockLogger);
        $event   = $handler->handle($payload);

        // Assert
        $this->assertInstanceOf(Event::class, $event);
        $this->assertSame('123', $event->id);
    }

    public function testHandleWithInvalidToken(): void
    {
        // Arrange
        $verificationToken = 'valid_token';
        $payload           = [];

        // Assert
        $this->expectException(InvalidVerificationTokenException::class);

        // mock
        $mockLogger = $this->mockLogger();

        // Act
        $handler = new Handler($verificationToken, $mockLogger);
        $handler->handle($payload);
    }

    public function testHandleWithArrayPayload(): void
    {
        // Arrange
        $verificationToken = 'valid_token';
        $payload           = [
            'id'                  => '123',
            'application_id'      => 456,
            'resource'            => 'accounting:expense_application',
            'action'              => 'created',
            'created_at'          => '2023-10-01T00:00:00Z',
            'expense_application' => [
                'id'           => 1,
                'company_id'   => 2,
                'status'       => 'draft',
                'applicant_id' => 3,
            ],
        ];

        // mock
        $this->setVerificationToken($verificationToken);
        $mockLogger = $this->mockLogger();

        // Act
        $handler = new Handler($verificationToken, $mockLogger);
        $event   = $handler->handle($payload);

        // Assert
        $this->assertInstanceOf(Event::class, $event);
        $this->assertSame('123', $event->id);
    }

    public function testVerifyTokenWithValidToken(): void
    {
        // Arrange
        $verificationToken = 'valid_token';

        // mock
        $this->setVerificationToken($verificationToken);
        $mockLogger = $this->mockLogger();

        // Act
        $handler = new Handler($verificationToken, $mockLogger);
        $result  = $handler->verifyToken('valid_token');

        // Assert
        $this->assertTrue($result);
    }

    public function testVerifyTokenWithInvalidToken(): void
    {
        // Arrange
        $verificationToken = 'valid_token';

        // Assert
        $this->expectException(InvalidVerificationTokenException::class);

        // mock
        $this->setVerificationToken($verificationToken);
        $mockLogger = $this->mockLogger();

        // Act
        $handler = new Handler($verificationToken, $mockLogger);
        $handler->verifyToken('invalid_token');
    }

    /** @return LoggerInterface */
    private function mockLogger()
    {
        $mockLogger = $this->createMock(LoggerInterface::class);
        $mockLogger->method('debug');
        return $mockLogger;
    }

    private function setVerificationToken(string $token): void
    {
        $_SERVER[VerificationToken::KEY] = $token;
    }
}
