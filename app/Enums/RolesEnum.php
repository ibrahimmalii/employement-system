<?php

namespace App\Enums;

enum RolesEnum: int
{
    case ADMIN = 1;
    case EMPLOYEE = 2;

    public static function getRoles(): array
    {
        return [
            self::ADMIN,
            self::EMPLOYEE
        ];
    }
}
