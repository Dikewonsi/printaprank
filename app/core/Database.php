<?php
// app/core/Database.php
namespace App\core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $pdo = null;

    public static function connection(): PDO
    {
        if (self::$pdo instanceof PDO) {
            return self::$pdo;
        }

        $cfg = Config::db();

        $dsn = match ($cfg['driver']) {
            'mysql' => sprintf(
                'mysql:host=%s;port=%d;dbname=%s;charset=%s',
                $cfg['host'], $cfg['port'], $cfg['name'], $cfg['charset']
            ),
            'pgsql' => sprintf(
                'pgsql:host=%s;port=%d;dbname=%s',
                $cfg['host'], $cfg['port'], $cfg['name']
            ),
            default => throw new \InvalidArgumentException("Unsupported driver: {$cfg['driver']}")
        };

        try {
            self::$pdo = new PDO($dsn, $cfg['user'], $cfg['pass'], [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
                // Optional: persistent connections
                // PDO::ATTR_PERSISTENT => true,
            ]);
        } catch (PDOException $e) {
            if (Config::isDebug()) {
                throw new PDOException("DB connection failed: " . $e->getMessage(), (int) $e->getCode());
            }
            throw new PDOException("DB connection failed.");
        }

        // Ensure SQL mode / timezone as needed (optional MySQL tuning)
        // self::$pdo->exec("SET time_zone = '+00:00'");

        return self::$pdo;
    }
}
