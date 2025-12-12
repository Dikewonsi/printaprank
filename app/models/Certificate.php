<?php
    // app/models/Certificate.php
    namespace App\models;

    use App\core\Database; // 

    class Certificate
    {
        // 1. Define the properties (must match database column names)
        public ?int $id;
        public ?string $title;
        public ?float $price; // Use float or string depending on your DB
        public ?string $description;
        public ?string $image; // Example of another likely column
        
        // Define other necessary properties here (e.g., created_at)

        public function __construct(array $data)
        {
            $this->id          = isset($data['id']) ? (int)$data['id'] : null;
            $this->title       = $data['title'] ?? null;
            $this->price       = isset($data['price']) ? (float)$data['price'] : null;
            $this->description = $data['description'] ?? null;
            $this->image  = $data['image'] ?? null;
        }
        // Fetch all certificates
        public static function all(): array
        {
            $pdo = Database::connection();
            $stmt = $pdo->query("SELECT * FROM certificates");
            $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            // Map each row to a Certificate object
            return array_map(fn($row) => new Certificate($row), $rows);
        }

        // Fetch a single certificate by ID
        public static function find(int $id): ?Certificate
        {
            $pdo = Database::connection();
            $stmt = $pdo->prepare("SELECT * FROM certificates WHERE id = ?");
            $stmt->execute([$id]);
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);

            return $row ? new Certificate($row) : null;
        }

        public static function findByVariant(int $variantId): ?Certificate
        {
            $pdo = Database::connection();
            $stmt = $pdo->prepare("SELECT * FROM certificates WHERE shopify_variant_id = ?");
            $stmt->execute([$variantId]);
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);

            return $row ? new Certificate($row) : null;
        }


    }
