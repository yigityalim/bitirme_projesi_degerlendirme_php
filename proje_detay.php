<?php
session_start();
require 'veritabani.php';
if (!isset($_SESSION['kullanici'])) {
    header('Location: giris.php');
    exit;
}

$projeler = $vt->query("SELECT * FROM bitirme_projesi_degerlendirme.proje WHERE id = " . $_SESSION['proje_id'])->fetch_all(MYSQLI_ASSOC);

$juriler = $vt->query("SELECT juri.* FROM juri_atama 
    INNER JOIN juri ON juri.id = juri_atama.juri_id
    WHERE juri_atama.proje_id = " . $_SESSION['proje_id'])->fetch_all(MYSQLI_ASSOC);

$puanlar = $vt->query('SELECT puan FROM bitirme_projesi_degerlendirme.puanlar WHERE proje_id = ' . $_SESSION['proje_id'])->fetch_all(MYSQLI_ASSOC);
$ortalama = array_reduce($puanlar, fn($carry, $item) => $carry + $item['puan']) / count($puanlar);

$ogrenciler = $vt->query('SELECT * FROM ogrenci
INNER JOIN proje_atama ON ogrenci.id = proje_atama.ogrenci_id
INNER JOIN proje ON proje_atama.proje_id = proje.id WHERE proje_id=' . $_SESSION['proje_id'])->fetch_all(MYSQLI_ASSOC);
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
                <th scope="col">Proje Adı</th>
                <th scope="col">proje Açıklaması</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($projeler as $proje): ?>
                <tr>
                    <td><?= $proje['id'] ?></td>
                    <td><?= $proje['proje_baslik'] ?></td>
                    <td><?= $proje['proje_aciklama'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="row">
            <h2 class="fw-bold">Jüri Üyeleri </h2>
        </div>
        <div class="row">
            <form action="proje_detay_guncelle.php" method="post">
                <table class="table table-dark table-responsive table-striped table-hover">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Jüri Adı</th>
                        <th scope="col">Jüri Telefonu</th>
                        <th scope="col">Jüri Görevi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($juriler as $key => $juri): ?>
                        <tr>
                            <td><?= $juri['id'] ?></td>
                            <td><?= $juri['ad'] ?> <?= $juri['soyad'] ?></td>
                            <td><?= preg_replace('/(\d{4})(\d{3})(\d{2})(\d{2})/', '($1) $2 $3 $4', $juri['telefon']); ?></td>
                            <td><?= $juri['gorev'] ?></td>
                            <td>
                                <label class="w-100">
                                    <input
                                        <?= $_SESSION['kullanici']['id'] == $juri['id'] ? '' : 'readonly' ?>
                                        value="<?= $puanlar[$key]['puan'] ?>"
                                        class="input-number w-100 input-group-text bg-dark text-white"
                                        min="0"
                                        max="100"
                                        name="puanlar[]"
                                        type="number"
                                        placeholder="Puan Giriniz:">
                                        <input type="hidden" name="juri_id[]" value="<?= $juri['id'] ?>">
                                        <input type="hidden" name="key[]"
                                           value="<?= $_SESSION['kullanici']['id'] == $juri['id'] ? $key : '' ?>">
                                </label>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="4" class="text-end">Toplam Puan:</td>
                        <td class="text-center"><?= $ortalama ?></td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-end">
                            <input type="hidden" name="juri_id" value="<?= $_SESSION['kullanici']['id'] ?>">
                            <input type="submit" class="btn btn-outline-success" value="Puanı Kaydet">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="row">
            <h2 class="fw-bold">Öğrenciler</h2>
        </div>
        <div class="row">
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
                        <td><?= $ogrenci['proje_id'] ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    document.querySelectorAll('.input-number').forEach(input => input.addEventListener('keyup',
        () => {
            if (parseInt(input.value) >= 100) input.value = 100;
            if (parseInt(input.value) <= -1 || parseInt(input.value) === -1) input.value = 0;
            if (input.value.startsWith('00')) input.value = input.value.slice(1);
        }))
</script>
</body>
</html>