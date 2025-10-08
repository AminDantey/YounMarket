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

$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
$stmt->execute([$order_id, $user_id]);
$order = $stmt->fetch();

if (!$order) {
    die("سفارشی یافت نشد.");
}

$stmt = $pdo->prepare("
    SELECT oi.quantity, oi.price, i.name 
    FROM order_items oi
    JOIN items i ON oi.item_id = i.id
    WHERE oi.order_id = ?
");
$stmt->execute([$order_id]);
$items = $stmt->fetchAll();
?>

<h2>🔎 جزئیات سفارش <?= htmlspecialchars($order['order_code']) ?></h2>
<p>📅 تاریخ ارسال: <?= htmlspecialchars($order['delivery_date']) ?></p>
<p>💰 جمع کل: <?= htmlspecialchars($order['total_price']) ?> تومان</p>
<p>📌 وضعیت: <?= htmlspecialchars($order['status']) ?></p>

<h3>📦 اقلام:</h3>
<table class="cart-table">
    <tr>
        <th>نام کالا</th>
        <th>تعداد</th>
        <th>قیمت واحد</th>
        <th>قیمت کل</th>
    </tr>
    <?php foreach ($items as $item): ?>
        <tr>
            <td><?= htmlspecialchars($item['name']) ?></td>
            <td><?= $item['quantity'] ?></td>
            <td><?= $item['price'] ?> تومان</td>
            <td><?= $item['price'] * $item['quantity'] ?> تومان</td>
        </tr>
    <?php endforeach; ?>
</table>

<a href="my_orders.php" class="btn">⬅️ بازگشت</a>


