<?php
session_start();
$loginError = $_SESSION['login_error'] ?? null;
$loginSuccess = $_SESSION['login_success'] ?? null;
unset($_SESSION['login_error'], $_SESSION['login_success']);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Giriş Yap | Akıllı Emlak Sistemi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-lg">
          <div class="card-body">
            <h3 class="card-title text-center mb-4">Giriş Yap</h3>

            <?php if ($loginError): ?>
              <div class="alert alert-danger"><?= htmlspecialchars($loginError) ?></div>
            <?php endif; ?>

            <?php if ($loginSuccess): ?>
              <div class="alert alert-success"><?= htmlspecialchars($loginSuccess) ?></div>
            <?php endif; ?>

            <form method="POST" action="login_process.php">
              <div class="mb-3">
                <label for="email" class="form-label">E-posta</label>
                <input type="email" class="form-control" id="email" name="email" required>
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">Şifre</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>

              <button type="submit" class="btn btn-primary w-100">Giriş Yap</button>
            </form>

            <div class="mt-3 text-center">
              <a href="register.php">Hesabınız yok mu? Kayıt olun</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
