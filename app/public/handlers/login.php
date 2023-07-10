<?php
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $conn = new PDO(dsn: 'pgsql:host=db;dbname=dbname', username: 'dbuser', password: 'dbpwd');
    $errors = isValidLogin($_POST, $conn);

    if (empty($errors)) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $userData = $stmt->fetch();
        if (!empty($userData) && (password_verify($password, $userData['password'])))
        {
            session_start();
            $_SESSION['user'] = ['email' => $userData['email']];
            header('Location: /main');
        } else {
            $errorsLogin['errors'] = '* Неверный пароль';
        }

    }
}
    require_once './htmlcod/login.html';
function isValidLogin(array $data,PDO $conn) :array {
    $errors = [];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!isset($email)) {
        $errors['email'] = 'email is required';
    }
    if (empty($email)) {
        $errors['email'] = 'email не доджно быть пустой';
    }

    if (!isset($password)) {
        $errors['password'] = 'password is required';
    }
    if (empty($password)) {
        $errors['password'] = 'password не доджно быть пустой';
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $userData = $stmt->fetch();
    if (empty($userData)) {
        $errors['email'] = 'Пользователь не зарегестрирован c таким email';
    }
    return $errors;
}
?>