<?php
session_start();
require_once 'veritabani.php';
if (!isset($_SESSION['kullanici'])) {
    header('Location: giris.php');
    exit;
}
$kullanici = $_SESSION['kullanici'];

$ogrenciler = $vt->query('SELECT o.*, p.id AS proje_id
FROM ogrenci o
INNER JOIN proje_atama pa ON o.id = pa.ogrenci_id
INNER JOIN proje p ON pa.proje_id = p.id
INNER JOIN juri_atama ja ON p.id = ja.proje_id
INNER JOIN juri j ON ja.juri_id = j.id
WHERE j.id = ' . $kullanici['id'])->fetch_all(MYSQLI_ASSOC);


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
    <title>Öğrenciler</title>
</head>
<body class="bg-dark text-white d-flex align-items-start justify-content-center h-100">
<div class="container mx-auto bg-dark text-white p-2 d-flex flex-column gap-4">
    <h1 class="fw-bold">Öğrenci Listesi</h1>
    <div class="row">
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
        <div>
            <table class="table table-dark table-responsive table-striped table-hover">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Öğrenci No</th>
                    <th scope="col">Öğrenci Adı</th>
                    <th scope="col">Öğrenci Soyadı</th>
                    <th scope="col">Öğrenci Mail</th>
                    <th scope="col">Öğrenci Telefon</th>
                    <th scope="col">Proje Numarası</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($ogrenciler as $ogrenci): ?>
                    <tr>
                        <td><?= $ogrenci['id'] ?></td>
                        <td><?= $ogrenci['ogrenci_no'] ?></td>
                        <td><?= $ogrenci['ad'] ?></td>
                        <td><?= $ogrenci['soyad'] ?></td>
                        <td><?= $ogrenci['email'] ?></td>
                        <td><?= preg_replace('/(\d{4})(\d{3})(\d{2})(\d{2})/', '($1) $2 $3 $4', $ogrenci['telefon']); ?></td>
                        <td>
                            <form action="proje.php" method="post">
                                <input type="hidden" name="proje_id" value="<?= $ogrenci['proje_id'] ?>">
                                <input type="submit" class="btn btn-outline-primary" value="Proje Detayları">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>