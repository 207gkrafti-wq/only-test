<?php
ob_start();
session_start();
include_once '../../config.php';
header("Location: ../reg.php");


try {
    function validReg()
    {
        // if (isset($_SESSION['user'])) {
        // header("Location: ../index.php");
        // exit();
        // }

        global $mysqli;
        $errors = [];

        //проверка на пустые поля
        $required = ['full_name', 'tel', 'email', 'login', 'password', 'password2'];
        foreach ($required as $name) {
            if (empty(trim($_POST[$name] ?? ''))) {
                // $errors = 'Заполните все поля!';
                $errors[] = 'Заполните все поля!';
                break;
            }
        }

        if (!filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Некорректный email';
        }

        //Проверка пароля
        if (strlen($_POST['password']) < 8) {
            $errors[] = 'Пароль должен быть от 8 символов!';
        }
        if ($_POST['password'] != $_POST['password2']) {
            $errors[] = 'Пароли не совпадают!';
        }
        if (!preg_match('/^[a-z\d_]+$/ui', trim($_POST['password']))) {
            $errors[] = 'Допустимые символы для пароля a-zA-Z 1-9 _ ';
        }

        //Проверка логина
        if (strlen($_POST['login']) < 6) {
            $errors[] = 'Логин должен быть от 6 символов!';
        }
        if (!preg_match('/^[a-z\d_]+$/ui', trim($_POST['login']))) {
            $errors[] = 'Допустимые символы для логина a-zA-Z 1-9 _ ';
        }
        $login = trim($_POST['login']);
        $tel = trim($_POST['tel']);
        $email = trim($_POST['email']);
        $conn = $mysqli->prepare("SELECT id FROM users WHERE login = ? OR tel = ? OR email = ?");
        $conn->bind_param('sss', $login, $tel, $email);
        $conn->execute();
        $result = $conn->get_result();

        if ($result->num_rows > 0) {
            $errors[] = 'Логин, почта или номер телефона уже заняты!';
            $conn->close();
        }
        return $errors;


    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = validReg();
        if (empty($errors)) {
            $fullName = trim($_POST['full_name']);
            $email = trim($_POST['email']);
            $tel = trim($_POST['tel']);
            $login = trim($_POST['login']);
            $hashPassword = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

            $conn = $mysqli->prepare('INSERT INTO users (full_name, login, tel, email, password) VALUES (?,?,?,?,?)');
            $conn->bind_param('sssss', $fullName, $login, $tel, $email, $hashPassword);
            $conn->execute();
            $conn->close();

            $_SESSION['message'] = 'Регистрация прошла успешно';
            unset($_SESSION['old_data']);
            header('Location: ../index.php');
        } else {
            $_SESSION['message'] = $errors;
            $_SESSION['old_data'] = [
                'full_name' => $_POST['full_name'],
                'login' => $_POST['login'],
                'email' => $_POST['email'],
                'tel' => $_POST['tel'],
                'password' => $_POST['password'],
            ];
            header('Location: ../reg.php');
        }
        exit();
    }
} catch (\Throwable $th) {
    $_SESSION['message'] = 'Что-то пошло не так';
    header('Location: ../reg.php');
    exit();
}

ob_end_flush()
    ?>