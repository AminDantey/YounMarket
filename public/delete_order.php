<?php
session_start();
require '../config/db.php';
include('../layout/header.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: ../registeration/login.php");
    exit;
}

if (!isset($_GET['id'])) {
    die("شناسه سفارش مشخص نیست.");
}

$order_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ? AND status = 'در انتظار تایید'");
$stmt->execute([$order_id, $user_id]);
$order = $stmt->fetch();

if (!$order) {
    die("این سفارش قابل حذف نیست.");
}

$deliveryDate = new DateTime($order['delivery_date']);
$now = new DateTime();
$hoursRemaining = ($deliveryDate->getTimestamp() - $now->getTimestamp()) / 3600;

if ($hoursRemaining < 48) {
    die("⏰ کمتر از ۴۸ ساعت به تاریخ ارسال باقی مانده. امکان حذف سفارش وجود ندارد.");
}

$stmt = $pdo->prepare("DELETE FROM orders WHERE id = ? AND user_id = ?");
$stmt->execute([$order_id, $user_id]);
?>

<p class="success-msg">✅ سفارش با موفقیت حذف شد.</p>
<a href="../view/my_orders.php" class="btn">بازگشت به سفارش‌ها</a>

