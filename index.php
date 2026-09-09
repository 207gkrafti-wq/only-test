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
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery.js"></script>
    <script src="js/jquery.mask.min.js"></script>
    <title>Личный кабинет</title>
</head>
<body>
    <div class="profile">
        <div class="profile__header">
            <h1 class="profile__title">Личный кабинет</h1>
            <a href="login/logout.php" class="profile__logout">Выход</a>
        </div>
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
        <ul class="user-info">
            <li class="user-info__item"><span class="user-info__label">ФИО:</span> <?= htmlspecialchars($_SESSION['user']['full_name']) ?></li>
            <li class="user-info__item"><span class="user-info__label">Логин:</span> <?= htmlspecialchars($_SESSION['user']['login']) ?></li>
            <li class="user-info__item"><span class="user-info__label">Email:</span> <?= htmlspecialchars($_SESSION['user']['email']) ?></li>
            <li class="user-info__item"><span class="user-info__label">Номер телефона:</span> <?= htmlspecialchars($_SESSION['user']['tel']) ?></li>
        </ul>
            <form action="update/upd_con.php" method="post" class="edit-form">
            <h2 class="edit-form__title">Смена личных данных</h2>
            <div class="edit-form__fields">
                <input type="text" name="full_name" id="full_name" class="edit-form__input" placeholder="ФИО"
                    value="<?= $_SESSION['old_data']['full_name'] ?? '' ?>">
                <input type="text" name="login" id="login" class="edit-form__input" placeholder="Логин"
                    value="<?= $_SESSION['old_data']['login'] ?? '' ?>">
                <input type="email" name="email" id="email" class="edit-form__input" placeholder="Email"
                    value="<?= $_SESSION['old_data']['email'] ?? '' ?>">
                <input type="tel" name="tel" id="tel" class="edit-form__input" placeholder="Телефон"
                    value="<?= $_SESSION['old_data']['tel'] ?? '' ?>">
            </div>
            <button type="submit" class="edit-form__button">Сохранить</button>
        </form>
            <form action="update/upd_pasw.php" method="post" class="edit-form">
            <h2 class="edit-form__title">Смена пароля</h2>
            <div class="edit-form__fields">
                <input type="password" name="old_password" id="password" class="edit-form__input password" placeholder="Старый пароль">
                <input type="password" name="new_password" id="new_password" class="edit-form__input password" placeholder="Новый пароль">
                <input type="password" name="new_password2" id="password2" class="edit-form__input password" placeholder="Подтвердите новый пароль">
                <label for="viewPassword" class="edit-form__checkbox-label">Показать пароль <input type="checkbox" id="viewPassword" class="edit-form__checkbox"></label>
            </div>
            <button type="submit" class="edit-form__button">Сохранить</button>
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
<?php ob_end_flush() ?>
