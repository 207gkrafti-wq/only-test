<?php
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
    <title>Home</title>
</head>
<body>
    <a href="login/logout.php">Выход</a>
    
</body>
</html>
