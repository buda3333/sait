<?php
namespace App\Controller;
use App\Model\User;
class UserController {
    public function signup() {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            $errors = $this->isValid($_POST);

            if (empty($errors)) {

                session_start();
                header('Location: /login');

                $email = $_POST['email'];
                $user = new User();
                if ($user->exists($email)) {
                    $errors['email'] = "Email already exists";
                } else {
                    $password = $_POST['password'];
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $user->save($_POST['name'], $email, $hash);
                }
            }
        }
        session_start();
        if (isset($_SESSION['user_id'])) {
            header('Location: /main');
        }
        require_once '../View/signup.html';
    }
    public function login(){
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $errors = $this->isValidLogin($_POST);
            if (empty($errors)) {
                $password = $_POST['password'];
                $user = new User();
                $userData = $user->get($_POST['email']);
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
    }
    public function logout()
    {
        session_start();

        unset($_SESSION['user_id']);
        header('Location: /login');
    }
    private function isValid(array $data) :array {
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
    private function isValidLogin(array $data) :array {
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
?>