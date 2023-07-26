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
$routes = require_once './../Config/routes.php';
$requestUri = $_SERVER['REQUEST_URI'];
if(isset($routes[$requestUri])) {
    [$class, $method] = $routes[$requestUri];
    $obj = new $class();
    $result = $obj->$method();
    extract($result['data']);
    require_once "./../View/{$result['view']}.phtml";
} else {
    require_once '../View/notFound.html';
}
?>