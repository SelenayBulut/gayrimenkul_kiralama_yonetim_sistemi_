<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'db.php';

if (!isset($_GET['id'])) {
    header("Location: listings.php");
    exit;
}

$listing_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Güncelleme isteği geldiyse
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("UPDATE emlak_ilanlari SET title=?, location=?, price=?, description=? WHERE id=? AND user_id=?");
    $stmt->bind_param("ssdssi", $title, $location, $price, $description, $listing_id, $user_id);
    $stmt->execute();

    header("Location: listings.php");
    exit;
}

// İlan bilgilerini al
$stmt = $conn->prepare("SELECT * FROM emlak_ilanlari WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $listing_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$listing = $result->fetch_assoc();

if (!$listing) {
    echo "İlan bulunamadı.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>İlan Güncelle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h2>İlan Güncelle</h2>
<a href="listings.php" class="btn btn-secondary mb-3">⟵ Listeye Dön</a>

<form method="POST" class="border p-4 rounded shadow-sm">
    <div class="mb-3">
        <label>Başlık</label>
        <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($listing['title']) ?>" required>
    </div>
    <div class="mb-3">
        <label>Lokasyon</label>
        <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($listing['location']) ?>" required>
    </div>
    <div class="mb-3">
        <label>Fiyat</label>
        <input type="number" step="0.01" name="price" class="form-control" value="<?= htmlspecialchars($listing['price']) ?>" required>
    </div>
    <div class="mb-3">
        <label>Açıklama</label>
        <textarea name="description" class="form-control" required><?= htmlspecialchars($listing['description']) ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Güncelle</button>
</form>

</body>
</html>
