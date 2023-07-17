<?php
class CartController
{
 public function addProduct(){
     session_start();
     if (!isset($_SESSION['user_id'])) {
         header('Location: /login');
     }
     if ($_SERVER['REQUEST_METHOD'] === "POST") {
         $errors = isValidAddProduct(['user_id' => $_SESSION['user_id'], 'product_id' => $_POST['product_id'], 'quantity' => $_POST['quantity']]);
         if (empty($errors)) {
             $conn = new PDO(dsn: 'pgsql:host=db;dbname=dbname', username: 'dbuser', password: 'dbpwd');
             $userId = $_SESSION['user_id'];
             $productId = $_POST['product_id'];
             $quantity = $_POST['quantity'];
             $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)
    ON CONFLICT (user_id, product_id) DO UPDATE SET quantity = cart.quantity + $quantity");
             $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'quantity' => $quantity]);
             header('Location: /main');
         }else {
             header('Location: /notFound');
         }
     }
     function isValidAddProduct(array $data) :array{
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
 }
 public function getCart(){
     session_start();
     if (!isset($_SESSION['user_id'])) {
         header('Location: /login');
     }
     $conn = new PDO(dsn: 'pgsql:host=db;dbname=dbname', username: 'dbuser', password: 'dbpwd');
     $session_id = $_SESSION['user_id'];
     $query = "SELECT tovary.name, cart.quantity, tovary.price * cart.quantity AS total_price
FROM cart INNER JOIN tovary ON cart.product_id = tovary.id WHERE user_id = :user_id";
     $stmt = $conn->prepare($query);
     $stmt->bindValue(':user_id', $_SESSION['user_id']);
     $stmt->execute();
     $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
//$totalSum = 0;
//$productSum = $res['quantity'] * getProductPrice($res['product_id']);
//$totalSum += $productSum;
//echo "Общая сумма: " . $totalSum;
     require_once '../View/getCart.phtml';
     function getProductPrice($product_id) {
         $conn = new PDO(dsn: 'pgsql:host=db;dbname=dbname', username: 'dbuser', password: 'dbpwd');
         $stmt = $conn->prepare("SELECT price FROM tovary WHERE id = :product_id");
         $stmt->bindParam(':product_id', $product_id);
         $stmt->execute();

         $result = $stmt->fetch(PDO::FETCH_ASSOC);

         return $result['price'];
     }
     function getProductName($product_id) {
         $conn = new PDO(dsn: 'pgsql:host=db;dbname=dbname', username: 'dbuser', password: 'dbpwd');

         $stmt = $conn->prepare("SELECT name FROM tovary WHERE id = :product_id");
         $stmt->bindParam(':product_id', $product_id);
         $stmt->execute();
         $result = $stmt->fetch(PDO::FETCH_ASSOC);
         return $result['name'];
     }
 }
}