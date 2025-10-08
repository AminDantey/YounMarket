<?php
session_start();
require '../config/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../registeration/admin_login.php");
    exit;
}

if (!isset($_GET['id'], $_GET['action'])) {
    die("درخواست نامعتبر است.");
}

$order_id = intval($_GET['id']);
$action = $_GET['action'];

if ($action === "approve") {
    $stmt = $pdo->prepare("UPDATE orders SET status = 'تایید شده' WHERE id = ?");
    $stmt->execute([$order_id]);
    echo "✅ سفارش تایید شد.";
} elseif ($action === "delete") {
    $stmt = $pdo->prepare("DELETE FROM orders WHERE id = ?");
    $stmt->execute([$order_id]);
    echo "🗑️ سفارش حذف شد.";
} else {
    die("عملیات نامعتبر است.");
}

echo "<br><a href='../view/manage_orders.php'>بازگشت به مدیریت سفارش‌ها</a>";
