<?php
namespace App\Model;
use PDO;
class Cart
{
    private int $userID;
    private int $productID;
    private int $quantity;

    public function __construct(int $userID)
    {
        $this->userID = $userID;
    }
    public function getProductID(): int
    {
        return $this->productID;
    }

    public function setProductID(int $productID): void
    {
        $this->productID = $productID;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }
    public static function getDescription(int $userID):array
    {
        $stmt = ConnectFactory::create()->prepare("SELECT carts.product_id, tovary.name, carts.quantity, tovary.price * carts.quantity AS total_price
                                FROM tovary INNER JOIN carts ON carts.product_id = tovary.id WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userID]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function saveProduct(): void
    {
        $stmt = ConnectFactory::create()->prepare("INSERT INTO carts (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)
                            ON CONFLICT (user_id, product_id) DO UPDATE SET quantity = excluded.quantity + carts.quantity");

        $stmt->execute(['user_id' => $this->userID, 'product_id' => $this->getProductID(), 'quantity' => $this->getQuantity()]);
    }


    public function clearCart(): void
    {
        $stmt = ConnectFactory::create()->prepare('DELETE FROM carts WHERE user_id = :user_id');
        $stmt->execute(['user_id' => $this->userID]);
    }
}