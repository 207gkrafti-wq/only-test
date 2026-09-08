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
    <script src="../js/jquery.mask.min.js"></script>
    <title>Вход</title>
</head>

<body>
    <?php
    if (isset($_SESSION['message'])) {
        echo "<div class=\"message\">";
        if (is_array($_SESSION['message'])) {
            foreach ($_SESSION['message'] as $key => $value) {
                echo $value.'; ';
            }
        } else {
            echo $_SESSION['message'];
        }
        echo "</div>";
        unset($_SESSION['message']);
    }
    ?>
    <form action="bc/bc_log.php" method="post" class="form-login">
        <h1>Авторизация</h1>
        <div class="form">
            <input type="text" name="login" id="login" placeholder="Ваш логин, email или телефон">
            <input type="password" name="password" id="password" class="password" placeholder="Пароль">
            <label for="viewPassword">показать пароль <input type="checkbox" name="" id="viewPassword"></label>
        </div>
        <button type="submit" class="btn">Войти</button>
        <p>Еще не зарегистрированы? <a href="reg.php">Регистрация</a></p>
    </form>
    <script>
        $('#login').on('input', function () {
            let value = $(this).val();

            if (value.startsWith('8') || value.startsWith('+7')) {
                $(this).mask('8(000)000-00-00');
            } else {
                $(this).unmask();
            }
        });
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