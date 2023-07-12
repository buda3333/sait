<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    print_r($_POST);die;
    $conn = new PDO(dsn: 'pgsql:host=db;dbname=dbname', username: 'dbuser', password: 'dbpwd');
    $user_id = $_POST['user_id'];
    $product_id = $_POST['product_id'];
    $quantity = 1;
    $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id,) VALUES (:user_id, :product_id)");
    $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id]);
    echo "Товар добавлен в корзину!";
}
?>