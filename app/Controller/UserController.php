<?php
class UserController {
    public function signup(){
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $conn = new PDO(dsn: 'pgsql:host=db;dbname=dbname', username: 'dbuser', password: 'dbpwd');
        $errors = isValid($_POST, $conn);


        if (empty($errors)) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $userData = $stmt->fetch();
            if (!empty($userData)) {
                $errors['email'] = 'Пользователь зарегестрирован c таким email';
            } else {
                $stmt = $conn->prepare("INSERT INTO users(name,email,password) VALUES (:name,:email,:password)");
                $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
                header('Location: /login');
            }
        }
    }
    require_once '../View/signup.html';
    function isValid(array $data) :array {
        $errors = [];

        if (!isset($data['name'])) {
            $errors['name'] = 'name is required';
        } elseif (empty($data['name'])) {
            $errors['name'] = 'имя не доджно быть пустой';
        } elseif (strlen($data['name']) < 2) {
            $errors['name'] = 'имя не доджно быть меньше двух';
        }

        if (!isset($data['email'])) {
            $errors['email'] = 'email is required';
        } elseif (empty($data['email'])) {
            $errors['email'] = 'email не доджно быть пустой';
        } elseif (strlen($data['email']) < 2) {
            $errors['email'] = 'email не доджно быть меньше двух';
        }

        if (!isset($data['password'])) {
            $errors['password'] = 'password is required';
        } elseif (empty($data['password'])) {
            $errors['password'] = 'password не доджно быть пустой';
        } elseif (strlen($data['password']) < 4) {
            $errors['password'] = 'password не доджно быть меньше четырех';
        }

        if ($data['passwordp'] !== $data['password']) {
            $errors['passwordp'] = 'password не совпадает';
        }
        return $errors;
    }
}
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $conn = new PDO(dsn: 'pgsql:host=db;dbname=dbname', username: 'dbuser', password: 'dbpwd');
            $errors = isValidLogin($_POST, $conn);

            if (empty($errors)) {
                $email = $_POST['email'];
                $password = $_POST['password'];
                $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
                $stmt->execute(['email' => $email]);
                $userData = $stmt->fetch();
                if (empty($userData)) {
                    $errors['email'] = 'Пользователь не зарегестрирован c таким email';
                } elseif (!empty($userData) && (password_verify($password, $userData['password']))) {
                    session_start();
                    $_SESSION['user_id'] = $userData['id'];
                    $_SESSION['email'] = $userData['email'];
                    //setcookie('username',$userData['name'], time() + 3600); // Срок действия: 1 час
                    header('Location: /main');
                } else {
                    $errorsLogin['errors'] = '* Неверный пароль';
                }

            }
        }
        require_once '../View/login.html';
        function isValidLogin(array $data,PDO $conn) :array {
            $errors = [];

            if (!isset($data['email'])) {
                $errors['email'] = 'email is required';
            } elseif (empty($data['email'])) {
                $errors['email'] = 'email не доджно быть пустой';
            }

            if (!isset($data['password'])) {
                $errors['password'] = 'password is required';
            } elseif (empty($data['password'])) {
                $errors['password'] = 'password не доджно быть пустой';
            }
            return $errors;
        }
    }
}