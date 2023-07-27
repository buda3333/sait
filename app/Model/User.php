<?php
namespace App\Model;
use PDO;
use App\Model\ConnectFactory;
class User
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;
    private PDO $conn;

    public function __construct(int $id, string $name, string $email, string $password)
    {
        $this->conn = ConnectFactory::create();
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public static function get(string $email): User|null
    {
        $conn = ConnectFactory::create();
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $data = $stmt->fetch();

        if (!$data) {
            return null;
        }

        return new User($data['id'], $data['name'], $data['email'], $data['password']);
    }

    public function save(): void
    {
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $this->name, 'email' => $this->email, 'password' => $this->password]);
    }

    public function exists(): bool
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $stmt->execute(['email' => $this->email]);
        $count = $stmt->fetchColumn();

        return $count > 0;
    }
}