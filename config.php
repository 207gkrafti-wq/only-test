<?php
$mysqli = new mysqli('localhost','root','mysql','only_test');

if ($mysqli -> connect_error) {
    die('Error'.$mysqli -> connect_error);
}
?>