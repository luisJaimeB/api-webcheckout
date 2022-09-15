<?php

namespace App\Constants;

class PaymentStatus
{
    public const REJECTED = 'REJECTED';
    public const PENDING = 'PENDING';
    public const APPROVED = 'APPROVED';

    public static function toArray(): array
    {
        return [
            self::REJECTED,
            self::PENDING,
            self::APPROVED,
        ];
    }

    public static function completed(string $status)
    {
        return in_array($status, [self::APPROVED, self::REJECTED]);
    }
}