<?php
session_start();
require_once 'db.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = trim($_POST['login']);  // Email veya telefon ile giriş
    $password = $_POST['password'];

    // Sorguyu hem email hem telefon ile kontrol edecek şekilde hazırla
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ? OR tel = ?");
    $stmt->bind_param("ss", $login, $login);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            header("Location: listings.php");
            exit;
        } else {
            $error = "Hatalı şifre.";
        }
    } else {
        $error = "Kullanıcı bulunamadı.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Giriş Yap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h2>Giriş Yap</h2>

<?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST" class="border p-4 shadow-sm rounded" style="max-width: 400px;">
    <div class="mb-3">
        <label for="login" class="form-label">E-posta veya Telefon Numarası</label>
        <input type="text" name="login" id="login" class="form-control" required placeholder="E-posta veya Telefon Numarası">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Şifre</label>
        <input type="password" name="password" id="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary w-100">Giriş Yap</button>
    <a href="register.php" class="btn btn-link mt-2 d-block text-center">Kayıt Ol</a>
</form>

</body>
</html>
