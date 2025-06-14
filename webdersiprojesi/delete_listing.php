<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'db.php';

if (isset($_GET['id'])) {
    $listing_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Güvenlik: Sadece kendi ilanını silebilir
    $stmt = $conn->prepare("DELETE FROM emlak_ilanlari WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $listing_id, $user_id);
    $stmt->execute();
}

header("Location: listings.php");
exit;
