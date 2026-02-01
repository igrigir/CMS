<?php

declare(strict_types=1);

namespace CMS\Services;

use CMS\Models\User;
use CMS\Models\Role;

class AuthService
{
    public function register(string $username, string $email, string $password, string $roleName = 'editor'): int
    {
        $userModel = new User();

        if ($userModel->userExistsByUsername($username)) {
            throw new \RuntimeException('Username already exists');
        }

        if ($userModel->userExistsByEmail($email)) {
            throw new \RuntimeException('Email already exists');
        }

        $role = (new Role())->getByName($roleName);
        if (!$role) {
            throw new \RuntimeException('Role not found');
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);

        return $userModel->create($username, $email, $hash, (int)$role['id']);
    }

    public function login(string $username, string $password): array
    {
        $user = (new User())->getByUsername($username);

        if (!$user) {
            throw new \RuntimeException('User not found');
        }

        if (!password_verify($password, $user['password'])) {
            throw new \RuntimeException('Invalid password');
        }

        return $user; // contains role_name from JOIN
    }

    public function logout(): void
    {
        (new SessionService())->destroy();
    }
}
