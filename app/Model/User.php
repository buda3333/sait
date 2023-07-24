<?php
class User
{
    private PDO $conn;
    public function __construct()
    {
        require_once "../Model/ConnectBD.php";
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
}