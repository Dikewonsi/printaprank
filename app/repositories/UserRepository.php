<?php
// app/repositories/UserRepository.php
namespace App\repositories;

use App\models\User;
use App\core\Database;
use PDO;

class UserRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function findByEmail(string $email): ?User
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch();
        return $row ? new User($row) : null;
    }

    public function findById(int $id): ?User
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ? new User($row) : null;
    }


    public function create(User $user): int
    {
        $stmt = $this->db->prepare("
            INSERT INTO users (name, email, password, membership_id, role)
            VALUES (:name, :email, :password, :membership_id, :role)
        ");
        $stmt->execute([
            'name'          => $user->name,
            'email'         => $user->email,
            'password'      => $user->password,
            'membership_id' => $user->membership_id,
            'role'          => $user->role,
        ]);
        return (int) $this->db->lastInsertId();
    }
}
