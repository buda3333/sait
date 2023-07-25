<?php
namespace App\Model;
use PDO;
use App\Model\ConnectFactory;
class User
{
    private PDO $conn;
    public function __construct()
    {
        $this->conn = ConnectFactory::create();
    }
    public function get(string $email):array|false
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public function save(string $name, string $email, string $password): void
    {
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);

    }
    public function exists(string $email): bool
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $count = $stmt->fetchColumn();

        return $count > 0;
    }
}