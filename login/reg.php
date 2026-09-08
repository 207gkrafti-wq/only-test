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
    <title>Регистрация</title>
</head>

<body>
    <?php
    if (isset($_SESSION['message'])) {
        echo "<div class=\"message\">" . $_SESSION['message'] . "</div>";
        unset($_SESSION['message']);
    }
    ?>
    <form action="bc/bc_reg.php" method="post" class="form-login">
        <h1>Регистрация</h1>
        <div class="form">
            <input type="text" name="full_name" id="full_name" placeholder="ФИО"
                value="<?= $_SESSION['old_data']['full_name'] ?? '' ?>">
                <input type="text" name="login" id="login" placeholder="Логин"
                    value="<?= $_SESSION['old_data']['login'] ?? '' ?>">
            <input type="email" name="email" id="email" placeholder="Почта"
                value="<?= $_SESSION['old_data']['email'] ?? '' ?>">
            <input type="tel" name="tel" id="tel" placeholder="Телефон"
                value="<?= $_SESSION['old_data']['tel'] ?? '' ?>">
            <input type="password" name="password" id="password" class="password" placeholder="Пароль"
                value="<?= $_SESSION['old_data']['password'] ?? '' ?>">
            <input type="password" name="password2" id="password2" class="password" placeholder="Повторный пароль">
            <label for="viewPassword">показать пароль <input type="checkbox" name="" id="viewPassword"></label>
        </div>
        <button type="submit" class="btn">Создать пользователя</button>
        <p>Уже зарегистрированы? <a href="index.php">Войти</a></p>
    </form>

    <script>
    </script>
    <script>
        $('#tel').mask('8(000)000-00-00')
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