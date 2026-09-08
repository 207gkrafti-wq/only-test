<?php
ob_start();
session_start();
include_once 'config.php';
if (!isset($_SESSION['user'])) {
    header("Location: login/");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/jquery.js"></script>
    <script src="js/jquery.mask.min.js"></script>
    <title>Home</title>
</head>
<body>
    <a href="login/logout.php">Выход</a>
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
    <ul>
        <li>ФИО: <?= $_SESSION['user']['full_name'] ?></li>
        <li>Логин: <?= $_SESSION['user']['login'] ?></li>
        <li>Email: <?= $_SESSION['user']['email'] ?></li>
        <li>Номер телефона: <?= $_SESSION['user']['tel'] ?></li>
    </ul>
    <form action="update/upd_con.php" method="post" class="form-login">
        <h1>Регистрация</h1>
        <div class="form">
            <input type="text" name="full_name" id="full_name" placeholder="ФИО"
                value="<?= $_SESSION['old_data']['full_name'] ?? '' ?>">
            <input type="text" name="login" id="login" placeholder="Логин"
                value="<?= $_SESSION['old_data']['login'] ?? '' ?>">
            <input type="email" name="email" id="email" placeholder="Email"
                value="<?= $_SESSION['old_data']['email'] ?? '' ?>">
            <input type="tel" name="tel" id="tel" placeholder="Телефон"
                value="<?= $_SESSION['old_data']['tel'] ?? '' ?>">
        </div>
        <button type="submit" class="btn">Сохранить</button>
    </form>
    <form action="" method="post" class="form-login">
        <h1>Регистрация</h1>
        <div class="form">
            <input type="password" name="old_password" id="password" class="password" placeholder="Старый пароль">
            <input type="password" name="new_password" id="password" class="password" placeholder="Новый пароль">
            <input type="password" name="new_password2" id="password2" class="password" placeholder="Подвердите новый пароль">
            <label for="viewPassword">показать пароль <input type="checkbox" name="" id="viewPassword"></label>
        </div>
        <button type="submit" class="btn">Сохранить</button>
    </form>
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
<?php ob_end_flush() ?>
