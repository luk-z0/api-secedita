<?php

namespace App\Enums;

enum RoleEnum: string
{
    case ADMIN = 'admin';
    case EDITOR = 'editor';
    case USER = 'user';

    public function id(): int
    {
        return match ($this) {
            self::ADMIN => 1,
            self::EDITOR => 2,
            self::USER => 3,
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Administrador',
            self::EDITOR => 'Editor',
            self::USER => 'Usuário',
        };
    }

    public function level(): int
    {
        return match ($this) {
            self::ADMIN => 99,
            self::EDITOR => 2,
            self::USER => 1,
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
