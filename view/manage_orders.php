<?php
session_start();
require '../config/db.php';
$_POST['admin'] = true;
include('../layout/header.php');

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../registeration/admin_login.php");
    exit;
}

$stmt = $pdo->query("SELECT o.*, u.first_name, u.last_name, u.email
                     FROM orders o
                     JOIN users u ON o.user_id = u.id
                     WHERE o.status = 'در انتظار تایید'
                     ORDER BY o.created_at DESC");
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>📦 مدیریت سفارش‌ها</h2>

<?php if (empty($orders)): ?>
    <p>هیچ سفارشی در انتظار تایید نیست.</p>
<?php else: ?>
    <table class="cart-table">
        <tr>
            <th>کد سفارش</th>
            <th>کاربر</th>
            <th>ایمیل کاربر</th>
            <th>تاریخ ارسال</th>
            <th>جمع کل</th>
            <th>وضعیت</th>
            <th>عملیات</th>
        </tr>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= htmlspecialchars($order['order_code']) ?></td>
                <td><?= htmlspecialchars($order['first_name'] . " " . $order['last_name']) ?></td>
                <td>
                    <?= htmlspecialchars($order['email']) ?>
                </td>
                <td><?= htmlspecialchars($order['delivery_date']) ?></td>
                <td><?= htmlspecialchars($order['total_price']) ?> تومان</td>
                <td><?= htmlspecialchars($order['status']) ?></td>

                <td>
                    <a href="../public/order_action.php?action=approve&id=<?= $order['id'] ?>" class="btn success">✔️ تایید</a>
                    <a href="../public/order_action.php?action=delete&id=<?= $order['id'] ?>" class="btn danger" onclick="return confirm('مطمئن هستید؟')">🗑️ حذف</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="../registeration/logout.php" class="btn danger">🚪 خروج</a>
<?php endif; ?>

