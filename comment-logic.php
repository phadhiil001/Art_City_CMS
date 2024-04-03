<?php

session_start();
// require('header.php');

if (isset($_POST['submit'])) {
    $name = $_SESSION['name'];
    $comment = $_SESSION['comment'];
} else {
    header('Location: index.html');
    exit();
}
