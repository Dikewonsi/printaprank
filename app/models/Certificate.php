<?php
    // app/models/Certificate.php
    namespace App\models;

    use App\core\Database; // assuming you already have a Database class for PDO connection

    class Certificate
    {
        // 1. Define the properties (must match database column names)
        public ?int $id;
        public ?string $title;
        public ?float $price; // Use float or string depending on your DB
        public ?string $description;
        public ?string $image_path; // Example of another likely column
        
        // Define other necessary properties here (e.g., created_at)

        public function __construct(array $data)
        {
            // 2. Assign the array data to the object properties
            $this->id = $data['id'] ?? null;
            $this->title = $data['title'] ?? null;
            $this->price = $data['price'] ?? null;
            $this->description = $data['description'] ?? null;
            $this->image_path = $data['image_path'] ?? null;
            
            // Use property promotion if your PHP version supports it (PHP 8.0+)
            // Otherwise, use the explicit assignment above.
        }
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

        // Fetch a single certificate by Shopify variant ID
        public static function findByVariant(int $variantId): ?array
        {
            $pdo = Database::connection();
            $stmt = $pdo->prepare("SELECT * FROM certificates WHERE shopify_variant_id = ?");
            $stmt->execute([$variantId]);
            $certificate = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $certificate ?: null;
        }

    }
