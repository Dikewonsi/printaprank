<?php
namespace App\repositories;

use App\core\Database;

class CertificateOrderRepository
{
    public function create(array $data)
    {
        // session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }

        $pdo = Database::connection();
        $stmt = $pdo->prepare("
        INSERT INTO certificate_orders (order_id, certificate_id, awardee_name, status, user_id)
        VALUES (:order_id, :certificate_id, :awardee_name, :status, :user_id)
        ");
        $stmt->execute([
            ':order_id'       => $data['order_id'],
            ':certificate_id' => $data['certificate_id'],
            ':awardee_name'   => $data['awardee_name'],
            ':status'         => $data['status'],
            ':user_id'        => $data['user_id'],
        ]);
    }

    public function getByUserId(int $userId): array
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare("
            SELECT co.id, co.order_id, co.certificate_id, co.awardee_name, co.status,
                c.title, c.price
            FROM certificate_orders co
            JOIN certificates c ON co.certificate_id = c.id
            WHERE co.user_id = :user_id
            ORDER BY co.id DESC
        ");
        $stmt->execute(['user_id' => $userId]);
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Dynamically compute file_name
        foreach ($rows as &$row) {
            $row['file_name'] = "certificate_{$row['order_id']}_{$row['certificate_id']}.pdf";
        }

        return $rows;
    }
}
