<?php
session_start();

if (!isset($_SESSION['kullanici'])) {
    header('Location: giris.php');
    exit;
}

session_destroy();
$_SESSION['kullanici'] = null;
header('Location: giris.php');