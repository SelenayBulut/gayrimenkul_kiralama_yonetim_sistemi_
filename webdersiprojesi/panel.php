<?php
// panel.php - Kullanıcı paneli
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<h2>Hoş geldiniz!</h2>
<a href="ilan_ekle.php">Yeni İlan Ekle</a> |
<a href="ilanlar.php">İlanlarım</a> |
<a href="logout.php">Çıkış Yap</a>


<!-- ilan_ekle.php -->
<form action="ilan_kaydet.php" method="post">
    <input type="text" name="baslik" placeholder="Başlık" required>
    <textarea name="aciklama" placeholder="Açıklama" required></textarea>
    <input type="text" name="adres" placeholder="Adres" required>
    <input type="number" name="fiyat" placeholder="Fiyat" required>
    <select name="tur">
        <option>Ev</option>
        <option>Dükkan</option>
        <option>Arsa</option>
    </select>
    <select name="durum">
        <option>Boş</option>
        <option>Dolu</option>
    </select>
    <button type="submit">Kaydet</button>
</form>

<?php
// ilan_kaydet.php
require_once 'db.php';
session_start();

$user_id = $_SESSION['user_id'];
$baslik = $_POST['baslik'];
$aciklama = $_POST['aciklama'];
$adres = $_POST['adres'];
$fiyat = $_POST['fiyat'];
$tur = $_POST['tur'];
$durum = $_POST['durum'];
$tarih = date('Y-m-d');

$stmt = $conn->prepare("INSERT INTO ilanlar (user_id, baslik, aciklama, adres, fiyat, tur, durum, tarih) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isssdsss", $user_id, $baslik, $aciklama, $adres, $fiyat, $tur, $durum, $tarih);
$stmt->execute();

header("Location: ilanlar.php");
exit();
?>