<?php
namespace App\repositories;

use App\core\Database;

class CertificateOrderRepository
{
    public function create(array $data)
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare("
            INSERT INTO certificate_orders (order_id, certificate_id, awardee_name, status)
            VALUES (:order_id, :certificate_id, :awardee_name, :status)
        ");
        $stmt->execute([
            ':order_id'      => $data['order_id'],
            ':certificate_id'=> $data['certificate_id'],
            ':awardee_name'  => $data['awardee_name'],
            ':status'        => $data['status'],
        ]);
    }
}
