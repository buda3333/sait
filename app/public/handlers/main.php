<?php
session_start();
if (!isset($_SESSION['user'])) {
//if(isset($_COOKIE['username'])){
    $conn = new PDO('pgsql:host=db;dbname=dbname', 'dbuser', 'dbpwd');
    $products = $conn->query("SELECT * FROM tovary")->fetchAll(PDO::FETCH_ASSOC);
    $username = $_SESSION['user_id']['email'];
    require_once './htmlcod/main.phtml';
} else {
    header('Location: /login');
}

?>
