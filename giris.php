<?php
session_start();
require 'veritabani.php';
if (isset($_SESSION['kullanici'])) header('Location: index.php');

$juriler = $vt->query("SELECT * FROM juri")->fetch_all(MYSQLI_ASSOC);
$kontrol = false;
if ($_POST) {
    $secilenJuri = $_POST['juriler'];
    $sifre = $_POST['sifre'];

    $juri = $vt->query("SELECT * FROM juri WHERE id = '$secilenJuri'")->fetch_assoc();

    if ($juri['sifre'] == $sifre) {
        $_SESSION['kullanici'] = $juri;
        header('Location: index.php');
    } else {
        $kontrol = true;
    }
}
?>
<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Giriş Yap</title>
</head>
<body class="bg-dark text-white">
<div class="container-sm mx-auto">
    <h1 class="fw-bold text-center">Giriş Yap</h1>
    <form action="" method="post">
        <div class="mb-3">
            <label for="eposta" class="form-label">Akademisyen</label>
            <select name="juriler" type="email" class="bg-dark text-white form-select" id="eposta">
                <?php foreach ($juriler as $juri): ?>
                    <option value="<?= $juri['id'] ?>"><?= $juri['unvan']?> <?= $juri['ad'] ?> <?= $juri['soyad']?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="sifre" class="form-label">Şifre</label>
            <input name="sifre" type="password" class="bg-dark text-white form-control" id="sifre">
        </div>
        <button type="submit" class="btn btn-primary">Giriş Yap</button>
    </form>
    <?php if ($kontrol): ?>
        <div class="alert alert-danger mt-4" role="alert">
            E-posta veya şifre hatalı!
            <script>setTimeout(() => document.querySelector('.alert').remove(), 3000)</script>
        </div>
    <?php endif; ?>
</div>
</body>
</html>