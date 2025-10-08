<?php
session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>خروج - YounMarket</title>
    <link rel="stylesheet" href="../styles/auth_pages.css">
</head>
<body>
<div class="container-center">
    <div class="auth-container">
        <span class="auth-brand">YounMarket</span>
        <h2>✅ از حساب کاربری خارج شدید</h2>
        <p style="text-align:center;">تا بعد!</p>
        <div style="text-align:center;">
            <a class="back-btn" href="login.php">صفحه ورود کاربران</a>
            <a class="back-btn" href="admin_login.php">صفحه ورود ادمین</a>
        </div>
    </div>
</div>
</body>
</html>
