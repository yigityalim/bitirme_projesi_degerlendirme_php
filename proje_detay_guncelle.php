<?php
session_start();
require 'veritabani.php';
if (!isset($_SESSION['kullanici'])) {
    header('Location: giris.php');
    exit;
}
$key = null;
foreach($_POST['key'] as $index => $value) {
    if($value !== '') {
        $key = $index;
        break;
    }
}
$vt->query("UPDATE puanlar SET puan=" . $_POST['puanlar'][$key] . " WHERE proje_id=" . $_SESSION['proje_id'] . " AND juri_id=" . $_POST['juri_id']);
header('Location: proje_detay.php');
exit;