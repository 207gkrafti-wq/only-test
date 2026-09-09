# Личный кабинет

Минималистичное веб-приложение для управления профилем пользователя.

## Технологии

PHP 8.2+ • MySQL 8.0+ • jQuery • CSS Grid

## Установка

```bash
git clone https://github.com/yourusername/your-repo.git
cd your-repo
```

Создайте `.env` в корне:
```env
DB_HOST=localhost
DB_NAME=only_test
DB_USER=your_username
DB_PASS=your_password
RECAPTCHA_SECRET=your_secret
```

Импортируйте БД:
```bash
mysql -u your_username -p only_test < only_test.sql
```

## Функционал

- Регистрация и авторизация
- Редактирование профиля
- Смена пароля
- Google reCAPTCHA

## Безопасность

- Password hashing
- PDO prepared statements
- XSS protection

## Лицензия

MIT