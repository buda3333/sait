<?php


use App\Controller\MainController;
use App\Controller\UserController;
use App\Controller\CartController;

return [
    '/signup' => [UserController::class, 'signup'],
    '/login' => [UserController::class, 'login'],
    '/logout' => [UserController::class, 'logout'],
    '/main' => [MainController::class, 'main'],
    '/addProduct' => [CartController::class, 'addProduct'],
    '/getCart' => [CartController::class, 'getCart'],
    '/deleteAll' => [CartController::class, 'deleteAll']
];