<?php

namespace Shimoning\FreeeSdk\Webhook\Utilities;

use Shimoning\FreeeSdk\Exceptions\InvalidVerificationTokenException;

/**
 * Class VerificationToken
 */
class VerificationToken
{
    public const KEY = 'HTTP_X_FREEE_TOKEN';

    /**
     * Get the verification token from the request headers
     *
     * @return string
     * @throws InvalidVerificationTokenException
     */
    public static function get(): string
    {
        if (!isset($_SERVER[self::KEY])) {
            throw new InvalidVerificationTokenException('Verification token not found', 400);
        }

        return $_SERVER[self::KEY];
    }

    /**
     * Verify the verification token
     *
     * @param string $token
     * @return boolean
     * @throws InvalidVerificationTokenException
     */
    public static function verify(string $token): bool
    {
        if (self::get() === $token) {
            return true;
        }

        throw new InvalidVerificationTokenException('Invalid verification token', 400);
    }
}
