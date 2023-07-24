<?php
class CartController
{
    public function addProduct(){
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $errors = $this->isValidAddProduct(['user_id' => $_SESSION['user_id'], 'product_id' => $_POST['product_id'], 'quantity' => $_POST['quantity']]);
            if (empty($errors)) {
                require_once "../Model/Cart.php";
                $carts = new Cart();
                $carts->addProducts($_SESSION['user_id'], $_POST['product_id'],$_POST['quantity']);
                header('Location: /main');
            }else {
                header('Location: /notFound');
            }
        }
    }
    private function isValidAddProduct(array $data) :array{
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
        return  $errors;
    }
    public function getCart(){
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }
        require_once "../Model/Cart.php";
        $carts = new Cart();
        $result = $carts->getDescription($_SESSION['user_id']);
        require_once '../View/getCart.phtml';
    }
}