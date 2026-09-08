<?php
ob_start();
session_start();
include_once '../config.php';
if (!isset($_SESSION['user'])) {
    header("Location: ../login/");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: ../");
    exit();
}


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
        // $required = ['full_name', 'tel', 'email', 'login'];
        // foreach ($required as $name) {
        //     if (empty(trim($_POST[$name] ?? ''))) {
        //         // $errors = 'Заполните все поля!';
        //         $errors[] = 'Заполните все поля!';
        //         break;
        //     }
        // }

        if (!filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL) && !empty($_POST['email'])) {
            $errors[] = 'Некорректный email';
        }

        //Проверка логина
        if (strlen($_POST['login']) < 6 && !empty($_POST['login'])) {
            $errors[] = 'Логин должен быть от 6 символов!';
        }
        if (!preg_match('/^[a-z\d_]+$/ui', trim($_POST['login'])) && !empty($_POST['login'])) {
            $errors[] = 'Допустимые символы для логина a-zA-Z 1-9 _ ';
        }
        $login = trim($_POST['login']) ?? null;
        $tel = trim($_POST['tel']) ?? null;
        $email = trim($_POST['email']) ?? null;
        $conn = $mysqli->prepare("SELECT id FROM users WHERE login = ? OR tel = ? OR email = ?");
        $conn->bind_param('sss', $login, $tel, $email);
        $conn->execute();
        $result = $conn->get_result();

        if ($result->num_rows > 0) {
            $errors[] = 'Логин, почта или номер телефона уже заняты!';
        }
        $conn->close();
        return $errors;


    }

    function getUserByLogin()
    {
        global $mysqli;
        $id = $_SESSION['user']['id'];
        $stmt = $mysqli->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return $row;
        }

        return null;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = validReg();
        if (empty($errors)) {
            $fullName = !empty(trim($_POST['full_name'])) ? trim($_POST['full_name']) : $_SESSION['user']['full_name'];
            $email = !empty(trim($_POST['email'])) ? trim($_POST['email']) : $_SESSION['user']['email'];
            $tel = !empty(trim($_POST['tel'])) ? trim($_POST['tel']) : $_SESSION['user']['tel'];
            $login = !empty(trim($_POST['login'])) ? trim($_POST['login']) : $_SESSION['user']['login'];
            $id = $_SESSION['user']['id'];

            $conn = $mysqli->prepare('UPDATE users SET full_name = ?, login = ?, tel = ?, email = ? WHERE users.id = ?;');
            $conn->bind_param('ssssi', $fullName, $login, $tel, $email, $id);
            $conn->execute();
            $conn->close();

            $_SESSION['message'] = 'Данные обновлены';
            unset($_SESSION['old_data']);
            $user = getUserByLogin();
            if ($user) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'full_name' => $user['full_name'],
                    'login' => $user['login'],
                    'email' => $user['email'],
                    'tel' => $user['tel'],
                ];
            }
            header('Location: ../');
        } else {
            $_SESSION['message'] = $errors;
            $_SESSION['old_data'] = [
                'full_name' => $_POST['full_name'],
                'login' => $_POST['login'],
                'email' => $_POST['email'],
                'tel' => $_POST['tel'],
            ];
            header('Location: ../');
        }
        exit();
    }
} catch (\Throwable $th) {
    $_SESSION['message'] = 'Что-то пошло не так';
    header('Location: ../');
    exit();
}
ob_end_flush();
?>