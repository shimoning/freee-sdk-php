<?php

namespace Tests\Webhook\Utilities;

use PHPUnit\Framework\TestCase;
use Shimoning\FreeeSdk\Webhook\Utilities\VerificationToken;

class VerificationTokenTest extends TestCase
{
    protected function setUp(): void
    {
        // 初期化処理
        $_SERVER = [];
    }

    public function testGetReturnsTokenWhenPresent(): void
    {
        // Arrange
        $_SERVER[VerificationToken::KEY] = 'test-token';

        // Act
        $result = VerificationToken::get();

        // Assert
        $this->assertSame('test-token', $result);
    }

    public function testGetReturnsNullWhenTokenIsNotPresent(): void
    {
        // Arrange
        unset($_SERVER[VerificationToken::KEY]);

        // Act
        $result = VerificationToken::get();

        // Assert
        $this->assertNull($result);
    }

    public function testVerifyReturnsTrueWhenTokenMatches(): void
    {
        // Arrange
        $_SERVER[VerificationToken::KEY] = 'valid-token';

        // Act
        $result = VerificationToken::verify('valid-token');

        // Assert
        $this->assertTrue($result);
    }

    public function testVerifyReturnsFalseWhenTokenDoesNotMatch(): void
    {
        // Arrange
        $_SERVER[VerificationToken::KEY] = 'valid-token';

        // Act
        $result = VerificationToken::verify('invalid-token');

        // Assert
        $this->assertFalse($result);
    }

    public function testVerifyReturnsFalseWhenTokenIsNotSet(): void
    {
        // Arrange
        unset($_SERVER[VerificationToken::KEY]);

        // Act
        $result = VerificationToken::verify('any-token');

        // Assert
        $this->assertFalse($result);
    }
}
