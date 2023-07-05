<?php
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $conn = new PDO(dsn: 'pgsql:host=db;dbname=dbname', username: 'dbuser', password: 'dbpwd');
    $errors = isValid($_POST, $conn);

    if (empty($errors)) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users(name,email,password) VALUES (:name,:email,:password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
        $stmt = $conn->prepare("SELECT * FROM users WHERE name = :name");
        $stmt->execute(['name' => $name]);
        $resul = $stmt->fetch();
        print_r('id=' . $resul['id']);
        print_r('<br>');
        print_r('name=' . $resul['name']);
        print_r('<br>');
        print_r('email=' . $resul['email']);
    }
}

    function isValid(array $data,PDO $conn) :array {
        $errors = [];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordp = $_POST['passwordp'];

        if (!isset($name)) {
            $errors['name'] = 'name is required';
        }
        if (empty($name)) {
            $errors['name'] = 'имя не доджно быть пустой';
        }
        if (strlen($name) < 2) {
            $errors['name'] = 'имя не доджно быть меньше двух';
        }

        if (!isset($email)) {
            $errors['email'] = 'email is required';
        }
        if (empty($email)) {
            $errors['email'] = 'email не доджно быть пустой';
        }
        if (strlen($email) < 2) {
            $errors['email'] = 'email не доджно быть меньше двух';
        }

        if (!isset($password)) {
            $errors['password'] = 'password is required';
        }
        if (empty($password)) {
            $errors['password'] = 'password не доджно быть пустой';
        }
        if (strlen($password) < 4) {
            $errors['password'] = 'password не доджно быть меньше четырех';
        }

        if ($passwordp !== $password) {
            $errors['passwordp'] = 'password не совпадает';
        }

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $userData = $stmt->fetch();
        if (!empty($userData)) {
          $errors['email'] = 'Пользователь зарегестрирован c таким email';
        }
       return $errors;
    }

?>
<!DOCTYPE html>
<html lang="ru" dir="ltr">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="wrapper">
        <h2>Регистрация</h2>
        <form action="#" method="POST">
            <div class="input-box">
                <input type="text" placeholder="Введите имя" name="name" id="name" required>
                <label style="color: red"> <?php
                if (isset($errors['name']))  {
                    echo $errors['name'];
                }
                ?></label>
            </div>
            <div class="input-box">
                <input type="text" placeholder="Введите емайл" name="email" id="email" required>
                <label style="color: red"> <?php
                if (isset($errors['email']))  {
                    echo $errors['email'];
                }
                ?></label>
            </div>
            <div class="input-box">
                <input type="password" placeholder="Введите пароль" name="password" id="password" required>
                <label style="color: red"> <?php
                if (isset($errors['password']))  {
                    echo $errors['password'];
                }
                ?></label>
            </div>
            <div class="input-box">
                <input type="password" placeholder="Проверка пароля" name="passwordp" id="passwordp" required>
                <label style="color: red"> <?php
                    if (isset($errors['passwordp']))  {
                        echo $errors['passwordp'];
                    }
                    ?></label>
            </div>
            <div class="policy">
                <input type="checkbox">
                <h3>Согласен на обработку</h3>
            </div>
            <div class="input-box button">
                <input type="Submit" value="Регистрация">
            </div>
            <div class="text">
                <h3>Увас уже есть аккаунт? <a href="#">Ввести логин</a></h3>
            </div>
        </form>
    </div>

    </body>
    </html>
<style>
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }
    body{
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #4070f4;
    }
    .wrapper{
        position: relative;
        max-width: 430px;
        width: 100%;
        background: #fff;
        padding: 34px;
        border-radius: 6px;
        box-shadow: 0 5px 10px rgba(0,0,0,0.2);
    }
    .wrapper h2{
        position: relative;
        font-size: 22px;
        font-weight: 600;
        color: #333;
    }
    .wrapper h2::before{
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        height: 3px;
        width: 28px;
        border-radius: 12px;
        background: #4070f4;
    }
    .wrapper form{
        margin-top: 30px;
    }
    .wrapper form .input-box{
        height: 52px;
        margin: 18px 0;
    }
    form .input-box input{
        height: 100%;
        width: 100%;
        outline: none;
        padding: 0 15px;
        font-size: 17px;
        font-weight: 400;
        color: #333;
        border: 1.5px solid #C7BEBE;
        border-bottom-width: 2.5px;
        border-radius: 6px;
        transition: all 0.3s ease;
    }
    .input-box input:focus,
    .input-box input:valid{
        border-color: #4070f4;
    }
    form .policy{
        display: flex;
        align-items: center;
    }
    form h3{
        color: #707070;
        font-size: 14px;
        font-weight: 500;
        margin-left: 10px;
    }
    .input-box.button input{
        color: #fff;
        letter-spacing: 1px;
        border: none;
        background: #4070f4;
        cursor: pointer;
    }
    .input-box.button input:hover{
        background: #0e4bf1;
    }
    form .text h3{
        color: #333;
        width: 100%;
        text-align: center;
    }
    form .text h3 a{
        color: #4070f4;
        text-decoration: none;
    }
    form .text h3 a:hover{
        text-decoration: underline;
    }
</style>
