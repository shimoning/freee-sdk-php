<?php

namespace Shimoning\FreeeSdk\Webhook;

use Psr\Log\LoggerInterface;
use Shimoning\FreeeSdk\Webhook\Domains\Common\Entities\Event;
use Shimoning\FreeeSdk\Webhook\Utilities\VerificationToken;
use Shimoning\FreeeSdk\Exceptions\InvalidVerificationTokenException;

class Handler
{
    public function __construct(
        public readonly string $verificationToken,
        protected ?LoggerInterface $logger = null,
    ) {
    }

    /**
     * Handle the webhook payload
     *
     * @param string|array<string, string|int|array<string, string|int>> $payload
     * @param boolean $verify
     * @return Event
     */
    public function handle(string|array $payload, bool $verify = true): Event
    {
        if ($verify) {
            $this->logger?->debug('Verifying token', [
                'expected' => $this->verificationToken,
                'received' => VerificationToken::get(),
            ]);
            VerificationToken::verify($this->verificationToken);
            $this->logger?->debug('Token verified');
        }

        $this->logger?->debug('Handling webhook payload', [
            'payload' => $payload,
        ]);

        if (is_string($payload)) {
            $this->logger?->debug('JSON coming');
            return Event::fromJson($payload);
        }

        $this->logger?->debug('Array coming');
        return Event::fromArray($payload);
    }

    /**
     * Verify the verification token
     *
     * @param string $token
     * @return boolean
     * @throws InvalidVerificationTokenException
     */
    public function verifyToken(string $token): bool
    {
        $this->logger?->debug('Manually verify token', [
            'expected' => $this->verificationToken,
            'received' => VerificationToken::get(),
        ]);

        if ($this->verificationToken === $token) {
            $this->logger?->debug('Token verified');
            return true;
        }

        throw new InvalidVerificationTokenException('Invalid verification token', 400);
    }
}
