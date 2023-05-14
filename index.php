<?php
session_start();
require 'veritabani.php';
if (!isset($_SESSION['kullanici'])) {
    header('Location: giris.php');
    exit;
}
$kullanici = $_SESSION['kullanici'];

$proje = $vt->query("SELECT _proje.*
                           FROM juri_atama
                           INNER JOIN juri ON juri.id = juri_atama.juri_id
                           INNER JOIN _proje ON _proje.id = juri_atama.proje_id
                           WHERE juri.id = '{$kullanici['id']}'")->fetch_assoc();

if (!isset($_SESSION['proje_id'])) $_SESSION['proje_id'] = $proje['id'];
?>
<!doctype html>
<html lang="tr" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Anasayfa</title>
    <style>
    </style>
</head>
<body class="bg-dark text-white d-flex align-items-start justify-content-center h-100">
<div class="container mx-auto bg-dark text-white p-2 d-flex flex-column gap-4">
    <h1 class="fw-bold">Bitirme Projesi Yönetim Sistemi</h1>
    <div class="row">
        <div class="col d-flex align-items-center justify-content-start">
            <h2 class="fw-semibold text-center mb-0">
                Hoşgeldiniz, <?php echo $kullanici['ad'] . ' ' . $kullanici['soyad']; ?></h2>
        </div>
        <div class="col d-flex align-items-center justify-content-end gap-3">
            <form action="cikis.php" method="post">
                <button type="submit" class="btn btn-outline-danger">Çıkış Yap</button>
            </form>
        </div>
    </div>
    <div class="row d-flex justify-content-start align-items-center">
        <div class="btn-group gap-3">
            <a href="ogrenci.php" class="btn btn-outline-primary rounded">Öğrenciler</a>
            <a href="form.php" class="btn btn-outline-primary rounded">Bitirme Projeleri</a>
            <a href="juri.php" class="btn btn-outline-primary rounded">Diğer Jüriler</a>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col">
            <h3 class="fw-bold mt-3">Proje Bilgileri</h3>
            <table class="table table-dark table-responsive table-striped table-hover">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Proje Adı</th>
                    <th scope="col">Proje Açıklaması</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?= $proje['id']; ?></td>
                    <td><?= $proje['proje_baslik']; ?></td>
                    <td><?= $proje['proje_aciklama']; ?></td>
                    <td class="text-center">
                        <a href="proje_detay.php" class="btn btn-outline-light">Detay</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
