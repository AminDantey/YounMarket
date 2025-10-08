<?php
session_start();
require '../config/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../registeration/admin_login.php");
    exit;
}

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM items WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: ../view/adminpage.php");
exit;
