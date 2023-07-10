<?php
$requetUri=$_SERVER["REQUEST_URI"];

if ($requetUri === '/signup') {
    require_once './handlers/signup.php';
}

elseif ($requetUri === '/login') {
    require_once './handlers/login.php';
}
elseif ($requetUri === '/main') {
    session_start();
    require_once './htmlcod/main.html';
}
else {
    require_once './htmlcod/notFound.html';
}

?>