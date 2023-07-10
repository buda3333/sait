<?php
$conn = new PDO('pgsql:host=db;dbname=dbname', 'dbuser', 'dbpwd');
$products = $conn->query("SELECT * FROM tovary")->fetchAll(PDO::FETCH_ASSOC);
require_once './htmlcod/main.html';
?>
