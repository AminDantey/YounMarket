<?php
session_start();
require '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo 'ابتدا وارد حساب کاربری شوید.';
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $item_id = intval($_POST['id']);
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("SELECT * FROM items WHERE id = ?");
    $stmt->execute([$item_id]);
    $item = $stmt->fetch();

    if (!$item) {
        http_response_code(404);
        echo 'کالا یافت نشد.';
        exit();
    }
    if ($item['stock'] <= 0) {
        http_response_code(400);
        echo 'کالا موجود نیست.';
        exit();
    }

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$item_id])) {
        $_SESSION['cart'][$item_id]['quantity']++;
    } else {
        $_SESSION['cart'][$item_id] = [
            'quantity' => 1,
            'price' => $item['price'],
            'name' => $item['name']
        ];
    }

    echo 'کالا به سبد خرید اضافه شد.';
} else {
    http_response_code(400);
    echo 'درخواست نامعتبر است.';
}
