<?php

if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header('Location: index.php');
    exit();
}

include_once 'load_env.php';


$mysqli = new mysqli(
    $_ENV['DB_HOSTNAME'] ?? '',
    $_ENV['DB_USERNAME'] ?? '',
    $_ENV['DB_PASSWORD'] ?? '',
    $_ENV['DB_DB'] ?? ''
);

if ($mysqli->connect_error) {
    die('Error' . $mysqli->connect_error);
}
?>