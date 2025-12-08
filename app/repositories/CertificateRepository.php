<?php
    namespace App\repositories;

    use App\core\Database;
    use App\models\Certificate;
    use PDO;

    class CertificateRepository
    {
        private PDO $db;

        public function __construct()
        {
            $this->db = Database::connection();
        }

        public function all(): array
        {
            $stmt = $this->db->query("SELECT * FROM certificates");
            $rows = $stmt->fetchAll();
            return array_map(fn($row) => new Certificate($row), $rows);
        }

        public function find(int $id): ?Certificate
        {
            $stmt = $this->db->prepare("SELECT * FROM certificates WHERE id = :id LIMIT 1");
            $stmt->execute(['id' => $id]);
            $row = $stmt->fetch();
            return $row ? new Certificate($row) : null;
        }
    }
