<?php
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
    ON CONFLICT (user_id, product_id) DO UPDATE SET quantity = cart.quantity + 1");
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
?>
    /*$plusQuantity = $stmt->fetchColumn();
    if ($plusQuantity) {
        $quantity += $plusQuantity;
        $stmt = $conn->prepare("UPDATE cart SET quantity = :quantity WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['quantity' => $quantity, 'user_id' => $user_id, 'product_id' => $product_id]);
    } else {
        $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
       $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'quantity' => $quantity]);
    }
    header('Location: /main');
}/*
?>