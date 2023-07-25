<?php
namespace App\Controller;
use App\Model\Product;
class MainController
{
 public function main(){
     session_start();
     if (!isset($_SESSION['user'])) {
         $product = new Product();
         $products = $product->getAll();
         $username = $_SESSION['email'];
         require_once '../View/main.phtml';
     } else {
         header('Location: /login');
     }
 }
}