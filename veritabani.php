<?php
try {
   $vt = new mysqli('localhost', 'root', 'root', 'bitirme_projesi_degerlendirme');
} catch (mysqli_sql_exception $e) {
   die("HATA: ".$e->getMessage());
}