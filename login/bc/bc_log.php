<?php
ob_start();
session_start();
include_once '../../config.php';
if (isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: ../");
    exit();
}

try {
    function validReg()
    {

        global $mysqli;
        $errors = [];

        //проверка на пустые поля
        $required = ['login', 'password'];
        foreach ($required as $name) {
            if (empty(trim($_POST[$name] ?? ''))) {
                $errors[] = 'Заполните все поля!';
                break;
            }
        }

        if (!checkCapcha()) {
            $errors[] = 'Подтвердите что вы не бот!';
        }

        $login = trim($_POST['login']);
        $conn = $mysqli->prepare("SELECT id, password FROM users WHERE login = ? OR tel = ? OR email = ?");
        $conn->bind_param('sss', $login, $login, $login);
        $conn->execute();
        $result = $conn->get_result();
        $row = $result->fetch_assoc();
        if ($result->num_rows == 0 || !password_verify(trim($_POST['password']), $row['password'])) {
            $errors[] = 'Неверный логин или пароль!';
        }
        $conn->close();
        return $errors;


    }
    function getUserByLogin()
    {
        global $mysqli;
        $login = trim($_POST['login']);
        $stmt = $mysqli->prepare("SELECT * FROM users WHERE login = ? OR tel = ? OR email = ?");
        $stmt->bind_param('sss', $login, $login, $login);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return $row;
        }

        return null;
    }

    function checkCapcha()
    {
        $key = getenv('KEY', );
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = [
            'secret' => $key,
            'response' => $_POST['g-recaptcha-response']
        ];
        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data),
            ]
        ];
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $result = json_decode($result, false);
        return $result->success;
    }
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = validReg();

        if (empty($errors)) {
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
            header('Location: ../../');
        } else {
            $_SESSION['message'] = $errors;
            header('Location: ../');
        }
        exit();
    }
} catch (\Throwable $th) {
    // $_SESSION['message'] = $th;
    $_SESSION['message'] = 'Что-то пошло не так';
    header('Location: ../');
    exit();
}

ob_end_flush()
    ?>