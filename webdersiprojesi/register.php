<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kayıt Ol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5" style="max-width: 500px;">
        <h2 class="mb-4">Kayıt Ol</h2>
        <form action="register_process.php" method="POST">
            <div class="mb-3">
                <label for="firstname" class="form-label">Adınız:</label>
                <input type="text" id="firstname" name="firstname" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label">Soyadınız:</label>
                <input type="text" id="lastname" name="lastname" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">E-posta:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="tel" class="form-label">Telefon Numarası:</label>
                <input type="tel" id="tel" name="tel" class="form-control" required pattern="[0-9\s\-\+\(\)]{10,15}" placeholder="Örn: 0555 555 55 55">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Şifre:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Kayıt Ol</button>
        </form>
    </div>
</body>
</html>
