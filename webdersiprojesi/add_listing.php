<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $location = trim($_POST['location']);
    $price = intval($_POST['price']);
    $description = trim($_POST['description']);
    $rooms = intval($_POST['rooms']);
    $living_room = intval($_POST['living_room']);
    $property_type = $_POST['property_type'];

    $image_path = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/png'];
        if (in_array($_FILES['photo']['type'], $allowed_types)) {
            $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $new_name = uniqid("ilan_", true) . "." . $ext;
            $upload_dir = "uploads/";

            if (!is_dir($upload_dir)) mkdir($upload_dir);
            move_uploaded_file($_FILES['photo']['tmp_name'], $upload_dir . $new_name);
            $image_path = $upload_dir . $new_name;
        } else {
            $error = "Sadece JPG ve PNG dosyaları yüklenebilir.";
        }
    }

    if (!$error && $title && $location && $price && $description) {
        $stmt = $conn->prepare("INSERT INTO emlak_ilanlari 
            (user_id, title, location, price, description, rooms, living_room, property_type, image_path) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issdsiiss", $user_id, $title, $location, $price, $description, $rooms, $living_room, $property_type, $image_path);
        if ($stmt->execute()) {
            header("Location: listings.php?success=1");
            exit;
        } else {
            $error = "Veritabanına kayıt sırasında hata oluştu.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Yeni İlan Ekle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h2>Yeni İlan Ekle</h2>

<?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data" class="border p-4 rounded shadow-sm" style="max-width: 700px;">
    <div class="mb-3">
        <label class="form-label">İlan Başlığı</label>
        <input type="text" name="title" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Lokasyon</label>
        <input type="text" name="location" class="form-control" required>
    </div>

  <div class="mb-3">
    <label class="form-label">Fiyat (₺)</label>
    <input type="number" name="price" class="form-control" min="0" required>
</div>


    <div class="mb-3">
        <label class="form-label">Açıklama</label>
        <textarea name="description" class="form-control" rows="4" required></textarea>
    </div>

    <div class="row">
        <div class="mb-3 col-md-6">
            <label class="form-label">Oda Sayısı</label>
            <select name="rooms" class="form-select" required>
                <?php for ($r = 1; $r <= 9; $r++): ?>
                    <option value="<?= $r ?>"><?= $r ?> Oda</option>
                <?php endfor; ?>
                <option value="10">10+ Oda</option>
            </select>
        </div>

        <div class="mb-3 col-md-6">
            <label class="form-label">Salon Sayısı</label>
            <select name="living_room" class="form-select" required>
                <option value="1">1 Salon</option>
                <option value="2">2 Salon</option>
            </select>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Konut Türü</label>
        <select name="property_type" class="form-select" required>
            <option value="Daire">Daire</option>
            <option value="Villa">Villa</option>
            <option value="Müstakil">Müstakil</option>
            <option value="Rezidans">Rezidans</option>
            <option value="Dubleks">Dubleks</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Fotoğraf Yükle</label>
        <input type="file" name="photo" accept=".jpg, .jpeg, .png" class="form-control">
    </div>

    <button type="submit" class="btn btn-success">Kaydet</button>
    <a href="listings.php" class="btn btn-secondary">Vazgeç</a>
</form>

</body>
</html>
