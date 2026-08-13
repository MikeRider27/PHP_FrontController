<?php

namespace App\Core;

abstract class Controller
{
    protected function requireAuth(): void
    {
        if (!Auth::check()) {
            header('location:?c=login');
            exit;
        }
    }

    protected function requireRole(array $roles): void
    {
        $usuario = Auth::user();
        if (!$usuario || !in_array($usuario['rol_descripcion'], $roles, true)) {
            $_SESSION['acceso_error'] = 'No tenés permiso para acceder a esa sección.';
            header('location:?c=home');
            exit;
        }
    }

    protected function render(string $view, array $data = []): void
    {
        extract($data);
        require BASE_PATH . '/view/partials/head.php';
        require BASE_PATH . '/view/' . $view . '.php';
        require BASE_PATH . '/view/partials/footer.php';
    }

    protected function renderPartial(string $view, array $data = []): void
    {
        extract($data);
        require BASE_PATH . '/view/' . $view . '.php';
    }
}
