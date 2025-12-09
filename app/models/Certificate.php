<?php
    // app/models/Certificate.php
    namespace App\models;

    use App\core\Database; // assuming you already have a Database class for PDO connection

    class Certificate
    {
        // Fetch all certificates
        public static function all(): array
        {
            $pdo = Database::connection();
            $stmt = $pdo->query("SELECT * FROM certificates");
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        // Fetch a single certificate by ID
        public static function find(int $id): ?array
        {
            $pdo = Database::connection();
            $stmt = $pdo->prepare("SELECT * FROM certificates WHERE id = ?");
            $stmt->execute([$id]);
            $certificate = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $certificate ?: null;
        }
    }
