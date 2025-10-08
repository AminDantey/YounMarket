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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_date = $_POST['delivery_date'] ?? null;

    if (!$new_date) {
        die("تاریخ ارسال الزامی است.");
    }

    $stmt = $pdo->prepare("UPDATE orders SET delivery_date = ? WHERE id = ? AND user_id = ? AND status = 'در انتظار تایید'");
    $stmt->execute([$new_date, $order_id, $user_id]);

    echo "تاریخ ارسال با موفقیت تغییر کرد.";
    echo "<br><a href='my_orders.php'>بازگشت به سفارش‌ها</a>";
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ? AND status = 'در انتظار تایید'");
$stmt->execute([$order_id, $user_id]);
$order = $stmt->fetch();

if (!$order) {
    die("این سفارش قابل ویرایش نیست.");
}
?>

<h2>ویرایش تاریخ ارسال سفارش <?= htmlspecialchars($order['order_code']) ?></h2>
<form method="POST" class="form">
    <label for="delivery_date">تاریخ جدید:</label>
    <input type="date" id="delivery_date" name="delivery_date" value="<?= htmlspecialchars($order['delivery_date']) ?>" required>
    <button type="submit" class="btn">ذخیره</button>
</form>
<a href="my_orders.php" class="btn danger">انصراف</a>