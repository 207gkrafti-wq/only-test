<?php
session_start();
include_once 'config.php';
if (!isset($_SESSION['user'])) {
    header("Location: login/");
    exit();
}
?>
