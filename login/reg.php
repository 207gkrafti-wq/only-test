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
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="../favicon.svg">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/jquery.js"></script>
    <script src="../js/jquery.mask.min.js"></script>
    <title>Регистрация</title>
</head>
<body class="auth">
        <div class="auth__container">
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
        <form action="bc/bc_reg.php" method="post" class="auth__form">
            <h1 class="auth__title">Регистрация</h1>
            <input type="text" name="full_name" id="full_name" class="auth__input" placeholder="ФИО"
                value="<?= $_SESSION['old_data']['full_name'] ?? '' ?>">
            <input type="text" name="login" id="login" class="auth__input" placeholder="Логин"
                value="<?= $_SESSION['old_data']['login'] ?? '' ?>">
            <input type="email" name="email" id="email" class="auth__input" placeholder="Почта"
                value="<?= $_SESSION['old_data']['email'] ?? '' ?>">
            <input type="tel" name="tel" id="tel" class="auth__input" placeholder="Телефон"
                value="<?= $_SESSION['old_data']['tel'] ?? '' ?>">
            <input type="password" name="password" id="password" class="auth__input password" placeholder="Пароль"
                value="<?= $_SESSION['old_data']['password'] ?? '' ?>">
            <input type="password" name="password2" id="password2" class="auth__input password" placeholder="Повторный пароль">
            <label for="viewPassword" class="auth__checkbox-label">Показать пароль <input type="checkbox" id="viewPassword" class="auth__checkbox"></label>
            <button type="submit" class="auth__button">Создать пользователя</button>
            <p class="auth__footer">Уже зарегистрированы? <a href="index.php" class="auth__link">Войти</a></p>
        </form>
    </div>
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