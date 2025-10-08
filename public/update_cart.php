<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo "ابتدا وارد شوید.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['action'])) {
    $item_id = intval($_POST['id']);
    $action = $_POST['action'];

    if (!isset($_SESSION['cart'][$item_id])) {
        http_response_code(404);
        echo "کالا در سبد پیدا نشد.";
        exit;
    }

    switch ($action) {
        case "increase":
            $_SESSION['cart'][$item_id]['quantity']++;
            echo "تعداد افزایش یافت.";
            break;

        case "decrease":
            $_SESSION['cart'][$item_id]['quantity']--;
            if ($_SESSION['cart'][$item_id]['quantity'] <= 0) {
                unset($_SESSION['cart'][$item_id]);
                echo "کالا حذف شد.";
            } else {
                echo "تعداد کاهش یافت.";
            }
            break;

        case "remove":
            unset($_SESSION['cart'][$item_id]);
            echo "کالا حذف شد.";
            break;

        default:
            http_response_code(400);
            echo "عملیات نامعتبر.";
    }
} else {
    http_response_code(400);
    echo "درخواست نامعتبر.";
}
