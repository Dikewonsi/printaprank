<?php
    // app/models/Membership.php
    namespace App\models;

    class Membership
    {
        public int $id;
        public string $name;
        public int $download_limit;
        public float $price;

        public function __construct(array $data = [])
        {
            $this->id             = $data['id'] ?? 0;
            $this->name           = $data['name'] ?? '';
            $this->download_limit = $data['download_limit'] ?? 0;
            $this->price          = $data['price'] ?? 0.0;
        }
    }
