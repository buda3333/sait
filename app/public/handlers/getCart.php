<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
}
$conn = new PDO(dsn: 'pgsql:host=db;dbname=dbname', username: 'dbuser', password: 'dbpwd');
$session_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = :user_id");
$stmt->bindParam(':user_id', $session_id);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    //echo "ID: " . $row['id'] . "<br>";
    //echo "User ID: " . $row['user_id'] . "<br>";
    echo "Товар: " . getProductName($row['product_id']) . "<br>";
    echo "Количество: " . $row['quantity'] . "<br>";
}
$totalSum = 0;
$productSum = $row['quantity'] * getProductPrice($row['product_id']);
$totalSum += $productSum;
echo "Общая сумма: " . $totalSum;
//require_once './htmlcod/getCart.phtml';
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

// Отформатировать данные в HTML-код
//$html = '<h1>Корзина</h1>';
//$html .= '<ul>';
//foreach ($cartItems as $item) {
  //  $html .= '<li>' . $item['name'] . ': ' . $item['quantity'] . '</li>';
//}
//$html .= '</ul>';

// Вернуть HTML-код
//echo $html;
?>
