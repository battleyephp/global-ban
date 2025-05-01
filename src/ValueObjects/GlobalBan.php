<?php

declare(strict_types=1);

namespace BattlEye\GlobalBan\ValueObjects;

final readonly class GlobalBan
{
    private function __construct(public bool $exists, public string $reason) {}

    /**
     * Create a new GlobalBan from a reason string.
     */
    public static function fromReason(string $reason): self
    {
        return new self($reason !== '' && $reason !== '0', $reason);
    }
}
