<?php
    namespace App\repositories;

    use App\core\Database;
    use PDO;

    class TransactionRepository
    {
        private PDO $db;

        public function __construct()
        {
            $this->db = Database::connection();
        }

        public function create(array $data): int
        {
            $stmt = $this->db->prepare("
                INSERT INTO transactions (user_id, shopify_order_id, status, amount)
                VALUES (:user_id, :shopify_order_id, :status, :amount)
            ");
            $stmt->execute([
                'user_id'         => $data['user_id'],
                'shopify_order_id'=> $data['shopify_order_id'],
                'status'          => $data['status'],
                'amount'          => $data['amount'],
            ]);
            return (int) $this->db->lastInsertId();
        }
    }
