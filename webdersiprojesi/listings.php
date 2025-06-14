<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$sql = "SELECT e.*, u.firstname, u.lastname, u.tel 
        FROM emlak_ilanlari e
        JOIN users u ON e.user_id = u.id
        ORDER BY e.id DESC";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Tüm İlanlar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h2>Tüm İlanlar</h2>

<a href="add_listing.php" class="btn btn-success mb-3">+ Yeni Kayıt Ekle</a>
<a href="logout.php" class="btn btn-danger mb-3 float-end">Çıkış Yap</a>

<?php while ($row = $result->fetch_assoc()): ?>
    <div class="card mb-3">
        <div class="row g-0">
            <div class="col-md-4">
                <?php if (!empty($row['image_path'])): ?>
                    <img src="<?= htmlspecialchars($row['image_path']) ?>" class="img-fluid rounded-start" alt="İlan Fotoğrafı">
                <?php else: ?>
                    <div class="text-center p-5 text-muted">Fotoğraf yok</div>
                <?php endif; ?>
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5>
                    <p class="card-text"><strong>Lokasyon:</strong> <?= htmlspecialchars($row['location']) ?></p>
                    <p class="card-text"><strong>Fiyat:</strong> <?= number_format($row['price'], 0, ',', '.') ?> ₺</p>
                    <p class="card-text"><strong>Oda:</strong> <?= htmlspecialchars($row['rooms']) ?> + <?= htmlspecialchars($row['living_room']) ?></p>
                    <p class="card-text"><strong>Konut Türü:</strong> <?= htmlspecialchars($row['property_type']) ?></p>
                    <p class="card-text"><?= nl2br(htmlspecialchars($row['description'])) ?></p>
                    <hr>
                    <p class="card-text"><small class="text-muted">İletişim: <?= htmlspecialchars($row['firstname']) ?> <?= htmlspecialchars($row['lastname']) ?> - <?= htmlspecialchars($row['tel']) ?></small></p>
                    <?php if ($row['user_id'] == $_SESSION['user_id']): ?>
                        <a href="edit_listing.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Güncelle</a>
                        <a href="delete_listing.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Silmek istediğinizden emin misiniz?');">Sil</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php endwhile; ?>

</body>
</html>
