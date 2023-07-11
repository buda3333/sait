<?php
$requetUri=$_SERVER["REQUEST_URI"];

if ($requetUri === '/signup') {
    require_once './handlers/signup.php';
} elseif ($requetUri === '/login') {
    require_once './handlers/login.php';
} elseif ($requetUri === '/main') {
    //session_start();
    //if (!isset($_SESSION['user'])) {
    if(isset($_COOKIE['username'])){
        require_once './handlers/main.php';
    } else {
        header('Location: /login');
    }
} else {
    require_once './htmlcod/notFound.html';
}
?>