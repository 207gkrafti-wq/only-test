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
        if (!isset($_SESSION['user'])) {
            header("Location: ../");
            exit();
        }

        global $mysqli;
        $errors = [];

        // проверка на пустые поля
        $required = ['old_password', 'new_password', 'new_password2'];
        foreach ($required as $name) {
            if (empty(trim($_POST[$name] ?? ''))) {
                $errors[] = 'Заполните все поля для смены пароля!';
                break;
            }
        }


        //Проверка пароля
        if (strlen($_POST['new_password']) < 8) {
            $errors[] = 'Пароль должен быть от 8 символов!';
        }
        if ($_POST['new_password'] != $_POST['new_password2']) {
            $errors[] = 'Пароли не совпадают!';
        }
        if (!preg_match('/^[a-z\d_]+$/ui', trim($_POST['new_password']))) {
            $errors[] = 'Допустимые символы для пароля a-zA-Z 1-9 _ ';
        }

        $id = $_SESSION['user']['id'];
        $conn = $mysqli->prepare('SELECT id, password FROM users WHERE id = ?');
        $conn->bind_param('i', $id);
        $conn->execute();
        $result = $conn->get_result();
        $row = $result->fetch_assoc();
        if ($result->num_rows == 0 || !password_verify(trim($_POST['old_password']), $row['password'])) {
            $errors[] = 'Неверный пароль!';
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
            $id = $_SESSION['user']['id'];
            $newHashPassword = password_hash(trim($_POST['new_password']), PASSWORD_DEFAULT);

            $conn = $mysqli->prepare('UPDATE users SET password = ? WHERE users.id = ?;');
            $conn->bind_param('si', $newHashPassword, $id);
            $conn->execute();
            $conn->close();

            $_SESSION['message'] = 'Пароль обновлен!';
            header('Location: ../');
        } else {
            $_SESSION['message'] = $errors;
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