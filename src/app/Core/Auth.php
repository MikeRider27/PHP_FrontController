<?php

namespace App\Core;

class Auth
{
    public static function login(array $usuario): void
    {
        $_SESSION['usuario'] = $usuario;
    }

    public static function logout(): void
    {
        $_SESSION = [];
        session_destroy();
    }

    public static function check(): bool
    {
        return isset($_SESSION['usuario']);
    }

    public static function user(): ?array
    {
        return $_SESSION['usuario'] ?? null;
    }
}
