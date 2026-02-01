<?php

declare(strict_types=1);

namespace CMS\Services;

use PDO;
use PDOException;

final class Database
{
    private static ?PDO $pdo = null;

    // this is the method for opening connection
    public static function getConnection(): PDO
    {
        if (self::$pdo instanceof PDO) {
            return self::$pdo;
        }

        $host     = self::env('DB_HOST', 'localhost');
        $port     = self::env('DB_PORT', '3306');
        $name     = self::env('DB_NAME', 'cms');
        $user     = self::env('DB_USER', 'root');
        $pass     = self::env('DB_PASS', '');
        $charset  = self::env('DB_CHARSET', 'utf8mb4');
        $timezone = self::env('DB_TIMEZONE', '+00:00');

        $dsn = "mysql:host={$host};port={$port};dbname={$name};charset={$charset}";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            self::$pdo = new PDO($dsn, $user, $pass, $options);
            self::$pdo->exec("SET time_zone = " . self::$pdo->quote($timezone));
        } catch (PDOException $e) {
            throw new \RuntimeException("Connection failed: " . $e->getMessage());
        }

        return self::$pdo;
    }

    public static function disconnect(): void
    {
        self::$pdo = null;
    }

    private static function env(string $key, string $default = ''): string
    {
        $value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);

        if ($value === false || $value === null || $value === '') {
            return $default;
        }

        return (string)$value;
    }
}
