<?php

if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header('Location: index.php');
    exit();
}

include_once 'load_env.php';


$mysqli = new mysqli(
    getenv('DB_HOSTNAME'),
    getenv('DB_USERNAME'),
    getenv('DB_PASSWORD'),
    getenv('DB_DB'),
);

if ($mysqli->connect_error) {
    die('Error' . $mysqli->connect_error);
}
?>