<?php

class Cart
{
    private PDO $conn;
    public function __construct()
    {
        require_once "../Model/ConnectBD.php";
        $this->conn = ConnectFactory::create();
    }
    public function addProducts(int $userId, int $productId, int $quantity): void
    {
        $stmt = $this->conn->prepare("INSERT INTO carts (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)
    ON CONFLICT (user_id, product_id) DO UPDATE SET quantity = carts.quantity + $quantity");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'quantity' => $quantity]);

    }
    public function getDescription(int $userId) :array
    {
        $stmt = $this->conn->prepare("SELECT carts.product_id, tovary.name, carts.quantity, tovary.price * carts.quantity AS total_price
                                FROM tovary INNER JOIN carts ON carts.product_id = tovary.id WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}