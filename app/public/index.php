<?php
$requetUri=$_SERVER["REQUEST_URI"];

spl_autoload_register(function ($class) {
    $path = str_replace('\\',DIRECTORY_SEPARATOR, $class) . '.php';
    $appRoot = dirname(__DIR__);
    $path = preg_replace('#^App#',$appRoot,$path);
    if (file_exists($path)) {
        require_once $path;
        return true;
    }
return false;
});
use App\Controller\UserController;
use App\Controller\MainController;
use App\Controller\CartController;
if ($requetUri === '/signup') {
        $object = new UserController();
        $object->signup();
} elseif ($requetUri === '/login') {
    $object = new UserController();
    $object->login();
} elseif ($requetUri === '/main') {
    $object = new MainController();
    $object->main();
} elseif ($requetUri === '/addProduct') {
    $object = new CartController();
    $object->addProduct();
}elseif ($requetUri === '/getCart') {
    $object = new CartController();
    $object->getCart();
}else {
    require_once '../View/notFound.html';
}
?>