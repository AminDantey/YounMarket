<?php
session_start();
require '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../registeration/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    die("سبد خرید شما خالی است!");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $delivery_date = $_POST['delivery_date'] ?? null;

    if (!$delivery_date) {
        die("لطفاً تاریخ ارسال را انتخاب کنید.");
    }

    // محاسبه جمع کل
    $total_price = 0;
    foreach ($cart as $item) {
        $total_price += $item['quantity'] * $item['price'];
    }

    // تولید کد یکتا برای سفارش 
    $order_code = "YM-" . date("Ymd") . "-" . rand(100,999);

    try {
        $pdo->beginTransaction();

        // درج در جدول orders
        $stmt = $pdo->prepare("INSERT INTO orders (user_id, order_code, total_price, delivery_date) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $order_code, $total_price, $delivery_date]);
        $order_id = $pdo->lastInsertId();

        // درج آیتم‌ها در جدول order_items
        $stmt = $pdo->prepare("INSERT INTO order_items (order_id, item_id, quantity, price) VALUES (?, ?, ?, ?)");
        foreach ($cart as $id => $item) {
            $stmt->execute([$order_id, $id, $item['quantity'], $item['price']]);
        }

        $pdo->commit();

        // خالی کردن سبد خرید
        unset($_SESSION['cart']);

        echo "سفارش شما با موفقیت ثبت شد. کد سفارش: " . htmlspecialchars($order_code);
        echo "<br><a href='../view/my_orders.php'>مشاهده سفارشات</a>";

    } catch (Exception $e) {
        $pdo->rollBack();
        die("خطا در ثبت سفارش: " . $e->getMessage());
    }
}
?>
