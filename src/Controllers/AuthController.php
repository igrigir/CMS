<?php

declare(strict_types=1);

namespace CMS\Controllers;

use CMS\Services\AuthService;
use CMS\Services\SessionService;

class AuthController
{
    public function showLogin(): void
    {
        require dirname(__DIR__) . '/Views/auth/login.php';
    }

    public function showRegister(): void
    {
        require dirname(__DIR__) . '/Views/auth/register.php';
    }

    public function login(array $data): void
    {
        $username = trim($data['username'] ?? '');
        $password = (string)($data['password'] ?? '');

        if ($username === '' || $password === '') {
            die('Username and password are required');
        }

        $auth = new AuthService();
        $user = $auth->login($username, $password);

        (new SessionService())
            ->set('user_id', (int)$user['id'])
            ->set('role', (string)$user['role_name'])
            ->set('loggedIn', true);

        header('Location: /vjezbe/cms/public/dashboard');
        exit;
    }

    public function register(array $data): void
    {
        $username = trim($data['username'] ?? '');
        $email    = trim($data['email'] ?? '');
        $password = (string)($data['password'] ?? '');
        $confirm  = (string)($data['confirm_password'] ?? '');

        if ($username === '' || $email === '' || $password === '') {
            die('Username, email and password are required');
        }

        if ($password !== $confirm) {
            die('Passwords do not match');
        }

        $auth = new AuthService();
        $userId = $auth->register($username, $email, $password, 'editor');

        // Auto-login after register
        (new SessionService())
            ->set('user_id', $userId)
            ->set('role', 'editor')
            ->set('loggedIn', true);

        header('Location: /vjezbe/cms/public/dashboard');
        exit;
    }

    public function logout(): void
    {
        (new AuthService())->logout();
        header('Location: /vjezbe/cms/public/login');
        exit;
    }
}
