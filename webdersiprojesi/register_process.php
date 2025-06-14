<?php
session_start();
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $tel = trim($_POST['tel']);
    $password = $_POST['password'];

    // Basit form doğrulama
    if (empty($firstname) || empty($lastname) || empty($email) || empty($tel) || empty($password)) {
        die("Lütfen tüm alanları doldurun.");
    }

    // Email formatı kontrolü
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Geçerli bir e-posta adresi giriniz.");
    }

    // Telefon numarası basit kontrolü (sadece rakam ve + işaretine izin veriliyor)
    if (!preg_match('/^[0-9+\s()-]{10,20}$/', $tel)) {
        die("Geçerli bir telefon numarası giriniz.");
    }

    // Email veya telefon zaten kayıtlı mı kontrol et
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? OR tel = ?");
    $stmt->bind_param("ss", $email, $tel);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        die("Bu e-posta veya telefon numarası zaten kayıtlı.");
    }
    $stmt->close();

    // Şifreyi hashle
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Veritabanına ekle
    $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email, tel, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $firstname, $lastname, $email, $tel, $hashed_password);
    $inserted = $stmt->execute();

    if ($inserted) {
        // Kayıt başarılı, istersen giriş yapıp session açabilirsin
        $_SESSION['user_id'] = $stmt->insert_id;
        header("Location: listings.php?success=1");
        exit;
    } else {
        die("Kayıt sırasında bir hata oluştu.");
    }
}
?>
