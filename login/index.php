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
    <title>Вход</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body class="auth">
    <div class="auth__container">
        <?php
        if (isset($_SESSION['message'])) {
            echo "<div class=\"message\">";
            if (is_array($_SESSION['message'])) {
                foreach ($_SESSION['message'] as $key => $value) {
                    echo $value . '; ';
                }
            } else {
                echo $_SESSION['message'];
            }
            echo "</div>";
            unset($_SESSION['message']);
        }
        ?>
                <form action="bc/bc_log.php" method="post" class="auth__form">
            <h1 class="auth__title">Вход</h1>
            <input type="text" name="login" id="login" class="auth__input" placeholder="Ваш логин, email или телефон">
            <input type="password" name="password" id="password" class="auth__input password" placeholder="Пароль">
                        <label for="viewPassword" class="auth__checkbox-label">Показать пароль <input type="checkbox"
                    id="viewPassword" class="auth__checkbox"></label>
            <div class="g-recaptcha" data-sitekey="6LeyF7ItAAAAAOjcVgUjVYnFRZzT36UQ80Er4FYr"></div>
            <div class="text-danger" id="recapchaError"></div>
            <button type="submit" class="auth__button">Войти</button>
            <p class="auth__footer">Ещё не зарегистрированы? <a href="reg.php" class="auth__link">Регистрация</a></p>
        </form>
    </div>
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