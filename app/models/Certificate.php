<?php
    namespace App\models;

    class Certificate
    {
        public int $id;
        public string $title;
        public string $description;
        public float $price;
        public string $image;

        public function __construct(array $data)
        {
            $this->id          = (int)$data['id'];
            $this->title       = $data['title'];
            $this->description = $data['description'];
            $this->price       = (float)$data['price'];
            $this->image       = $data['image'];
        }
    }
