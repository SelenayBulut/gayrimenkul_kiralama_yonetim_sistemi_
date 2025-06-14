<?php
$host = "localhost";
$username = "root";   // Senin MySQL kullanıcı adın
$password = "";       // Senin MySQL şifren
$database = "emlak_sistemi";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
}
?>
