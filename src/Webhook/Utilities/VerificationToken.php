<?php

namespace Shimoning\FreeeSdk\Webhook\Utilities;

/**
 * Class VerificationToken
 */
class VerificationToken
{
    public const KEY = 'HTTP_X_FREEE_TOKEN';

    /**
     * Get the verification token from the request headers
     *
     * @SuppressWarnings("PHPMD.Superglobals")
     * @return string | null
     */
    public static function get(): ?string
    {
        return $_SERVER[self::KEY] ?? null;
    }

    /**
     * Verify the verification token
     *
     * @param string $token
     * @return boolean
     */
    public static function verify(string $token): bool
    {
        return self::get() === $token;
    }
}
