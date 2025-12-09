<?php
namespace App\repositories;

use App\core\Database;
use PDO;

class DownloadRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function recordDownload(int $userId, int $certificateId, string $filePath): int
    {
        $stmt = $this->db->prepare("
            INSERT INTO downloads (user_id, certificate_id, file_path)
            VALUES (:user_id, :certificate_id, :file_path)
        ");
        $stmt->execute([
            'user_id' => $userId,
            'certificate_id' => $certificateId,
            'file_path' => $filePath,
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function byUser(int $userId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM downloads WHERE user_id = :uid ORDER BY created_at DESC");
        $stmt->execute(['uid' => $userId]);
        return $stmt->fetchAll();
    }
}