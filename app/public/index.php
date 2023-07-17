<?php
$requetUri=$_SERVER["REQUEST_URI"];

if ($requetUri === '/signup') {
    require_once '../Controller/UserController.php';
        $object = new UserController();
        $object->signup();
} elseif ($requetUri === '/login') {
    require_once '../Controller/UserController.php';
    $object = new UserController();
    $object->login();
} elseif ($requetUri === '/main') {
    require_once '../Controller/MainController.php';
    $object = new MainController();
    $object->main();
} elseif ($requetUri === '/addProduct') {
    require_once '../Controller/CartController.php';
    $object = new CartController();
    $object->addProduct();
}elseif ($requetUri === '/getCart') {
    require_once '../Controller/CartController.php';
    $object = new CartController();
    $object->getCart();
}else {
    require_once '../View/notFound.html';
}
?>