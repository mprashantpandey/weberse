<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case HR = 'hr';
    case Sales = 'sales';
    case Support = 'support';
    case Client = 'client';

    public static function values(): array
    {
        return array_map(static fn (self $role) => $role->value, self::cases());
    }
}
