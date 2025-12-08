<?php
// app/repositories/MembershipRepository.php
namespace App\repositories;

use App\models\Membership;
use App\core\Database;
use PDO;

class MembershipRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function all(): array
    {
        $stmt = $this->db->query("SELECT * FROM memberships");
        $rows = $stmt->fetchAll();
        return array_map(fn($row) => new Membership($row), $rows);
    }

    public function find(?int $id): ?Membership
    {
        if ($id === null) {
            return null;
        }
        $stmt = $this->db->prepare("SELECT * FROM memberships WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ? new Membership($row) : null;
    }

    public function seedDefaults(): void
    {
        $plans = [
            ['name' => 'Basic', 'download_limit' => 5, 'price' => 0],
            ['name' => 'Pro', 'download_limit' => 15, 'price' => 9.99],
            ['name' => 'Ultimate', 'download_limit' => 50, 'price' => 19.99],
        ];

        foreach ($plans as $plan) {
            $stmt = $this->db->prepare("
                INSERT INTO memberships (name, download_limit, price)
                VALUES (:name, :download_limit, :price)
            ");
            $stmt->execute($plan);
        }
    }
}
