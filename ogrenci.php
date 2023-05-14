<?php
session_start();
if (!isset($_SESSION['kullanici'])) {
    header('Location: giris.php');
    exit;
}
$kullanici = $_SESSION['kullanici'];
?>
<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Öğrenci</title>
</head>
<body>
<div class="container p-2">
    <h1 class="fw-bold">Öğrenciler</h1>
    <div class="d-flex justify-content-end">
        <a href="ogrenci-ekle.php" class="btn btn-primary">Öğrenci Ekle</a>
    </div>
    <form action="cikis.php" method="post">
        <button type="submit" class="btn btn-danger mt-2">
            Çıkış Yap
        </button>
    </form>
</div>
</body>
</html>