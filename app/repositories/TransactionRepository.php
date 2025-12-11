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

        // app/repositories/TransactionRepository.php (Updated findAllOrders method)

    public function findAllOrders(): array
    {
        $sql = "
            SELECT 
                t.id AS transaction_id, 
                t.status AS transaction_status, 
                t.amount, 
                t.created_at,
                MAX(u.name) AS user_name,
                MAX(c.title) AS certificate_title,
                MAX(co.awardee_name) AS awardee_name,
                MAX(d.id) IS NOT NULL AS is_downloaded,
                MAX(d.created_at) AS last_downloaded_at
            FROM transactions t
            LEFT JOIN users u ON t.user_id = u.id
            LEFT JOIN certificate_orders co ON t.id = co.order_id -- CHECK THIS JOIN KEY (order_id vs transaction_id)
            LEFT JOIN certificates c ON co.certificate_id = c.id
            LEFT JOIN downloads d ON t.user_id = d.user_id AND co.certificate_id = d.certificate_id
            GROUP BY t.id
            ORDER BY t.created_at DESC
        ";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
