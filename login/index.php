<?php
ob_start();
session_start();
include_once '../config.php';
if (isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../js/jquery.js"></script>
    <title>Вход</title>
</head>

<body>
    <?php
    if (isset($_SESSION['message'])) {
        echo "<div class=\"message\">" . $_SESSION['message'] . "</div>";
        unset($_SESSION['message']);
    }
    ?>
    <form action="" method="post" class="form-login">
        <h1>Авторизация</h1>
        <div class="form">
            <input type="text" name="login" id="login" placeholder="Логин">
            <input type="password" name="password" id="password" class="password" placeholder="Пароль">
            <label for="viewPassword">показать пароль <input type="checkbox" name="" id="viewPassword"></label>
        </div>
        <button type="submit" class="btn">Войти</button>
        <p>Еще не зарегистрированы? <a href="reg.php">Регистрация</a></p>
    </form>
    <script>
        $('#viewPassword').on('click', function () {
            if ($(this).is(':checked')) {
                $('.password').attr('type', 'text')
            } else {
                $('.password').attr('type', 'password')
            }
        })
    </script>
</body>

</html>
<?php
ob_end_flush();
?>