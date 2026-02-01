<?php

declare(strict_types=1);

namespace CMS\Models;

use PDO;

class User extends BaseModel
{
    public function userExistsByUsername(string $username): bool
    {
        $stmt = $this->db->prepare('SELECT 1 FROM users WHERE username = :username LIMIT 1');
        $stmt->execute([':username' => $username]);

        return (bool)$stmt->fetchColumn();
    }

    public function userExistsByEmail(string $email): bool
    {
        $stmt = $this->db->prepare('SELECT 1 FROM users WHERE email = :email LIMIT 1');
        $stmt->execute([':email' => $email]);

        return (bool)$stmt->fetchColumn();
    }

    public function getByUsername(string $username): ?array
    {
        $stmt = $this->db->prepare('
            SELECT u.*, r.name AS role_name
            FROM users u
            INNER JOIN roles r ON r.id = u.roleId
            WHERE u.username = :username
            LIMIT 1
        ');
        $stmt->execute([':username' => $username]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare('
            SELECT u.*, r.name AS role_name
            FROM users u
            INNER JOIN roles r ON r.id = u.roleId
            WHERE u.id = :id
            LIMIT 1
        ');
        $stmt->execute([':id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function create(string $username, string $email, string $passwordHash, int $roleId): int
    {
        $stmt = $this->db->prepare('
            INSERT INTO users (username, email, password, roleId)
            VALUES (:username, :email, :password, :roleId)
        ');
        $stmt->execute([
            ':username' => $username,
            ':email'    => $email,
            ':password' => $passwordHash,
            ':roleId'   => $roleId,
        ]);

        return (int)$this->db->lastInsertId();
    }
}
