<?php
session_start();
if (!isset($_SESSION['kullanici'])) {
    header('Location: giris.php');
    exit;
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
    <title>Form</title>
</head>
<body>
<div class="container">
    <h2 class="fw-bold">Bitirme Projesi Yönetim Sistemi</h2>
    <h3 class="fw-semibold">Bitirme Projesi Ekle</h3>
    <form>
        <div class="form-group">
            <label for="bitirme-projesi-id">Bitirme Projesi ID:</label>
            <input type="text" class="form-control" id="bitirme-projesi-id" name="bitirme-projesi-id">
        </div>
        <div class="form-group">
            <label for="proje-adi">Proje Adı:</label>
            <input type="text" class="form-control" id="proje-adi" name="proje-adi">
        </div>
        <div class="form-group">
            <label for="proje-danismani">Proje Danışmanı:</label>
            <input type="text" class="form-control" id="proje-danismani" name="proje-danismani">
        </div>
        <div class="form-group">
            <label for="juri-uyesi-1">1. Jüri Üyesi:</label>
            <input type="text" class="form-control" id="juri-uyesi-1" name="juri-uyesi-1">
        </div>
        <div class="form-group">
            <label for="juri-uyesi-2">2. Jüri Üyesi:</label>
            <input type="text" class="form-control" id="juri-uyesi-2" name="juri-uyesi-2">
        </div>
        <div class="form-group">
            <label for="juri-uyesi-3">3. Jüri Üyesi:</label>
            <input type="text" class="form-control" id="juri-uyesi-3" name="juri-uyesi-3">
        </div>
        <div class="form-group">
            <label for="juri-uyesi-4">4. Jüri Üyesi:</label>
            <input type="text" class="form-control" id="juri-uyesi-4" name="juri-uyesi-4
            ">
        </div>
        <div class="form-group">
            <label for="proje-suresi">Proje Süresi:</label>
            <input type="text" class="form-control" id="proje-suresi" name="proje-suresi">
        </div>
        <div class="form-group">
            <label for="proje-yili">Projenin Kaçıncı yılı?</label>
            <input type="text" class="form-control" id="proje-yili" name="proje-yili">
        </div>
    </form>
</div>
</body>
</html>
