<?php
    // app/models/Membership.php
    namespace App\models;

    use App\core\Database; // 

    class Membership
    {
        public int $id;
        public string $name;
        public int $download_limit;
        public float $price;

        public function __construct(array $data = [])
        {
            $this->id             = $data['id'] ?? 0;
            $this->name           = $data['name'] ?? '';
            $this->download_limit = $data['download_limit'] ?? 0;
            $this->price          = $data['price'] ?? 0.0;
        }

        // Fetch all certificates
        public static function all(): array
        {
            $pdo = Database::connection();
            $stmt = $pdo->query("SELECT * FROM memberships");
            return $stmt->fetchAll(\PDO::FETCH_OBJ); 
        }

        public static function find(int $id): ?object
        {
            $pdo = Database::connection();
            $stmt = $pdo->prepare("SELECT * FROM memberships WHERE id = ?");
            $stmt->execute([$id]);
            $membership = $stmt->fetch(\PDO::FETCH_OBJ);
            return $membership ?: null;
        }
    }
