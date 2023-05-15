<?php
session_start();
require 'veritabani.php';
if (!isset($_SESSION['kullanici'])) {
    header('Location: giris.php');
    exit;
}
$kullanici = $_SESSION['kullanici'];
$projeler = null;
$ogrenciler = null;

if (isset($_POST['proje_id'])) {
    $projeler = $vt->query('SELECT * FROM proje
                INNER JOIN proje_atama ON proje.id = proje_atama.proje_id   
                WHERE proje.id = ' . $_POST['proje_id'])->fetch_assoc();
    $ogrenciler = $vt->query('SELECT * FROM ogrenci
                INNER JOIN proje_atama ON ogrenci.id = proje_atama.ogrenci_id   
                WHERE proje_atama.proje_id = ' . $_POST['proje_id'])->fetch_all(MYSQLI_ASSOC);
} else {
    $projeler = $vt->query('SELECT * FROM proje')->fetch_all(MYSQLI_ASSOC);
}
?>
<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Form</title>
</head>
<body class="bg-dark text-white d-flex align-items-start justify-content-center h-100">
<div class="container mx-auto bg-dark text-white p-2 d-flex flex-column gap-4">
    <h1 class="fw-bold">Öğrenci Listesi</h1>
    <div class="row">
        <div class="col d-flex align-items-center justify-content-start">
            <h2 class="fw-semibold text-center mb-0">Proje Detayı</h2>
        </div>
        <div class="col">
            <h4 class="fw-semibold text-center mb-0">
                <?= $_SESSION['kullanici']['ad'] . ' ' . $_SESSION['kullanici']['soyad'] ?>
            </h4>
        </div>
        <div class="col d-flex align-items-center justify-content-end gap-3">
            <a href="<?= isset($_POST['proje_id']) ? 'ogrenci.php' : 'index.php'?>" class="btn btn-outline-light">Geri git</a>
            <form action="cikis.php" method="post">
                <button type="submit" class="btn btn-outline-danger">Çıkış Yap</button>
            </form>
        </div>
    </div>
    <div class="row">
        <?php if (isset($_POST['proje_id'])): ?>
            <h1>İlgili proje detayı <?= $_POST['proje_id'] ?>. Proje</h1>
            <div class="row">
                <table class="table table-dark table-responsive table-striped table-hover">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Proje Başlığı</th>
                        <th scope="col">Proje Açıklaması</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row"><?= $_POST['proje_id'] ?></th>
                        <td><?= $projeler['proje_baslik'] ?></td>
                        <td><?= $projeler['proje_aciklama'] ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <h2 class="my-4">Projeyi alan öğrenciler</h2>
                <table class="table table-dark table-responsive table-striped table-hover">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Öğrenci Adı</th>
                        <th scope="col">Öğrenci Soyadı</th>
                        <th scope="col">Öğrenci Numarası</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($ogrenciler as $ogrenci): ?>
                        <tr>
                            <th scope="row"><?= $ogrenci['id'] ?></th>
                            <td><?= $ogrenci['ad'] ?></td>
                            <td><?= $ogrenci['soyad'] ?></td>
                            <td><?= $ogrenci['ogrenci_no'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <h1>Tüm Projeler</h1>
            <table class="table table-dark table-responsive table-striped table-hover">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Proje Başlığı</th>
                    <th scope="col">Proje Açıklaması</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($projeler as $proje): ?>
                    <tr>
                        <th scope="row"><?= $proje['id'] ?></th>
                        <td><?= $proje['proje_baslik'] ?></td>
                        <td><?= $proje['proje_aciklama'] ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
<!--
yukarıdaki tüm projeleri listeleyen döngüde eğer proje daha detaylı
 hale getirilirse o zaman bunu ekleyip ilgili proje'nin detaylarına gidecek olan html kodu:
<td>
    <form action="<!proje detayına gidecek html sayfası!>" method="post">
        <input type="hidden" name="proje_id" value="<?= $proje['id'] ?>">
        <button type="submit" class="btn btn-outline-primary">Detay</button>
    </form>
</td>
-->