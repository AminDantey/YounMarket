<?php
session_start();
require '../config/db.php';
$_POST['admin'] = true;
include('../layout/header.php');

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../registeration/admin_login.php");
    exit;
}

$username = $_SESSION['username'];
$stmt = $pdo->query('SELECT * FROM items ORDER BY id DESC');
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="top-bar">
    <h2>👋 خوش آمدی <?= htmlspecialchars($username) ?></h2>
    <div>
        <a href="manage_orders.php" class="btn success">مدیریت سفارشات</a>
        <a href="add_item.php" class="btn success">➕ افزودن آیتم جدید</a>
        <a href="../registeration/logout.php" class="btn danger">🚪 خروج</a>
    </div>
</div>

<table class="cart-table">
    <tr>
        <th>عکس</th>
        <th>ID</th>
        <th>نام</th>
        <th>قیمت</th>
        <th>توضیحات</th>
        <th>عملیات</th>
    </tr>
    <?php foreach ($items as $item): ?>
        <tr>
            <td>
                <?php if (!empty($item['image'])): ?>
                    <img src="../uploads/<?= htmlspecialchars($item['image']) ?>" width="80">
                <?php else: ?>
                    بدون عکس
                <?php endif; ?>
            </td>
            <td><?= $item['id'] ?></td>
            <td><?= htmlspecialchars($item['name']) ?></td>
            <td><?= htmlspecialchars($item['price']) ?> تومان</td>
            <td><?= htmlspecialchars($item['description']) ?></td>
            <td>
                <a href="edit_item.php?id=<?= $item['id'] ?>" class="btn">✏️ ویرایش</a>
                <a href="../public/delete_item.php?id=<?= $item['id'] ?>" class="btn danger" onclick="return confirm('آیا مطمئنی می‌خواهی حذف کنی؟')">🗑️ حذف</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>


