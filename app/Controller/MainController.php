<?php

class MainController
{
 public function main(){
     session_start();
     if (!isset($_SESSION['user'])) {
         $conn = new PDO('pgsql:host=db;dbname=dbname', 'dbuser', 'dbpwd');
         $products = $conn->query("SELECT * FROM tovary")->fetchAll(PDO::FETCH_ASSOC);
         $username = $_SESSION['email'];
         require_once '../View/main.phtml';
     } else {
         header('Location: /login');
     }
 }
}