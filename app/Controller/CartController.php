<?php
namespace App\Controller;
use App\Model\Cart;
class CartController
{
    public function addProduct(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $errors = $this->isValidAddProduct([
                'user_id' => $_SESSION['user_id'],
                'product_id' => $_POST['product_id'],
                'quantity' => $_POST['quantity']
            ]);
            if (!empty($errors)) {
                $product = new Cart($_SESSION['user_id']['id']);
                $product->setQuantity($_POST['quantity']);
                $product->setProductID($_POST['product_id']);

                $product->saveProduct();
                header('Location: /main');
                exit;
            } else {
                header('Location: /notFound');
                exit;
            }
        }
    }

    private function isValidAddProduct(array $data): array
    {
        $errors = [];
        if (!is_numeric($data['user_id'])) {
            $errors[] = "Неверное значение user_id";
        }

        if (!is_numeric($data['product_id'])) {
            $errors[] = "Неверное значение product_id";
        }

        if (!is_numeric($data['quantity'])) {
            $errors[] = "Неверное значение quantity";
        }
        return $errors;
    }

    public function getCart()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }

        $result = Cart::getDescription($_SESSION['user_id']['id']);
        return [
            'view' => 'getCart',
            'data' => [
                'result' => $result
            ]
        ];
    }
    public function clearCart()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }
        $products = new Cart($_SESSION['user_id']['id']);

        $products->clearCart();
                header('Location: /getCart');
        }
    public function deleteProduct(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $product = new Cart($_SESSION['user_id']['id']);

            $product->deleteProduct();
            header('Location: /getCart');
        }
    }


}