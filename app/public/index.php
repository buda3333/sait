<?php
$requetUri=$_SERVER["REQUEST_URI"];

if ($requetUri === '/signup') {
    require_once './handlers/signup.php';
} elseif ($requetUri === '/login') {
    require_once './handlers/login.php';
} elseif ($requetUri === '/main') {
    require_once './handlers/main.php';
} elseif ($requetUri === '/addProduct') {
    require_once './handlers/addProduct.php';
}else {
    require_once './htmlcod/notFound.html';
}
?>