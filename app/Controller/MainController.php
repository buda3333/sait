<?php
namespace App\Controller;
use App\Model\Product;
class MainController
{
    private Product $product;
    public function __construct()
    {
        $this->product = new Product;
    }
        public function main()
        {
         session_start();
          if (!isset($_SESSION['user'])) {

         $products = $this->product->getAll();
         $username = $_SESSION['email'];

         return [
             'view' => 'main',
             'data' => [
                 'products' => $products,
                 'username' => $username
             ]
         ];
          } else {
          header('Location: /login');
          }
 }
}