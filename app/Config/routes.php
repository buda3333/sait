<?php


use App\Controller\MainController;
use App\Controller\UserController;
use App\Controller\CartController;

return [
    '/signup' => [UserController::class, 'signup'],
    '/login' => [UserController::class, 'login'],
    '/main' => [MainController::class, 'main'],
    '/logout' => [UserController::class, 'logout'],
    '/addProduct' => [CartController::class, 'addProduct'],
    '/getCart' => [CartController::class, 'getCart']
];