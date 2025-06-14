<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'db.php';

// Formdan gelen verileri al
$title = $_POST['title'];
$location = $_POST['location'];
$price = $_POST['price'];
$description = $_POST['description'];
$user_id = $_SESSION['user_id'];

// Güvenlik için hazırlıklı ifade (prepared statement)
$stmt = $conn->prepare("INSERT INTO emlak_ilanlari (user_id, title, location, price, description) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("issds", $user_id, $title, $location, $price, $description);

if ($stmt->execute()) {
    header("Location: listings.php?success=1");
    exit;
} else {
    echo "Hata: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
