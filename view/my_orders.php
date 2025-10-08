<?php
session_start();
require '../config/db.php';
$_POST['admin'] = false;
include('../layout/header.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: ../registeration/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll();
?>

<h2>📑 سفارش‌های من</h2>

<?php if (empty($orders)): ?>
    <p>شما هنوز سفارشی ثبت نکرده‌اید.</p>
<?php else: ?>
    <table class="cart-table">
        <tr>
            <th>کد سفارش</th>
            <th>تاریخ ارسال</th>
            <th>جمع کل</th>
            <th>وضعیت</th>
            <th>عملیات</th>
        </tr>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= htmlspecialchars($order['order_code']) ?></td>
                <td><?= htmlspecialchars($order['delivery_date']) ?></td>
                <td><?= htmlspecialchars($order['total_price']) ?> تومان</td>
                <td><?= htmlspecialchars($order['status']) ?></td>
                <td>
                    <a href="order_details.php?id=<?= $order['id'] ?>" class="btn">🔎 جزئیات</a>
                    <?php
                        $deliveryDate = new DateTime($order['delivery_date']);
                        $now = new DateTime();
                        $hoursRemaining = ($deliveryDate->getTimestamp() - $now->getTimestamp()) / 3600;
                        if ($order['status'] === 'در انتظار تایید' && $hoursRemaining >= 48):
                    ?>
                        <a href="edit_order.php?id=<?= $order['id'] ?>" class="btn">✏️ ویرایش</a>
                        <a href="../public/delete_order.php?id=<?= $order['id'] ?>" class="btn danger">🗑️ حذف</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>


</main>
<footer style="
    width: 100%;
    background: linear-gradient(90deg, #50589C, #3C467B, #6E8CFB);
    color: #fff;
    text-align: center;
    padding: 18px 0;
    font-size: 1rem;
    position: fixed;
    left: 0;
    bottom: 0;
    z-index: 100;
    box-shadow: 0 -2px 8px rgba(0, 0, 0, 0.08);
    letter-spacing: 1px;">
    © 2025 .YounMarket. All rights reserved
</footer>