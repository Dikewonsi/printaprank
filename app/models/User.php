<?php
// app/models/User.php
namespace App\models;

class User
{
    public int $id;
    public string $name;
    public string $email;
    public string $password; // hashed
    public ?int $membership_id;
    public string $role;

    public function __construct(array $data = [])
    {
        $this->id            = $data['id'] ?? 0;
        $this->name          = $data['name'] ?? '';
        $this->email         = $data['email'] ?? '';
        $this->password      = $data['password'] ?? '';
        $this->membership_id = $data['membership_id'] ?? null;
        $this->role          = $data['role'] ?? 'user';
    }
}
