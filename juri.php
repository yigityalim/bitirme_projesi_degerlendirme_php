<?php
session_start();
require 'veritabani.php';
if (!isset($_SESSION['kullanici'])) {
    header('Location: giris.php');
    exit;
}
$kullanici = $_SESSION['kullanici'];
$juriler = $vt->query('SELECT * FROM juri')->fetch_all(MYSQLI_ASSOC);
?>
<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Jüri</title>
</head>
<body class="bg-dark text-white d-flex align-items-start justify-content-center h-100">
<div class="container mx-auto bg-dark text-white p-2 d-flex flex-column gap-4">
    <h1 class="fw-bold">Diğer Tüm Jüriler</h1>
    <div class="row mb-4">
        <div class="col d-flex align-items-center justify-content-start">
            <h2 class="fw-semibold text-center mb-0">Proje Detayı</h2>
        </div>
        <div class="col">
            <h4 class="fw-semibold text-center mb-0">
                <?= $_SESSION['kullanici']['ad'] . ' ' . $_SESSION['kullanici']['soyad'] ?>
            </h4>
        </div>
        <div class="col d-flex align-items-center justify-content-end gap-3">
            <a href="index.php" class="btn btn-outline-light">Geri git</a>
            <form action="cikis.php" method="post">
                <button type="submit" class="btn btn-outline-danger">Çıkış Yap</button>
            </form>
        </div>
    </div>
    <div class="row">
        <table class="table table-dark table-responsive table-striped table-hover">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Jüri Adı</th>
                <th scope="col">Jüri Soyadı</th>
                <th scope="col">Jüri Telefon</th>
                <th scope="col">Jüri Ünvanı</th>
                <th scope="col">Jüri Görevi</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($juriler as $juri): ?>
                <tr>
                    <th scope="row"><?= $juri['id'] ?></th>
                    <td><?= $juri['ad'] ?></td>
                    <td><?= $juri['soyad'] ?></td>
                    <td><?= $juri['telefon'] ?></td>
                    <td><?= $juri['unvan'] ?></td>
                    <td><?= $juri['gorev'] ?></td>
                    <?php if ($juri['id'] == $kullanici['id']): ?>
                        <td>
                            <form action="proje_detay.php" method="post">
                                <input type="hidden" name="id" value="<?= $juri['id'] ?>">
                                <button type="submit" class="btn btn-outline-primary">Proje Detay</button>
                            </form>
                        </td>
                    <?php else: ?>
                        <td></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
