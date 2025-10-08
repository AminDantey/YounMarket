<?php
require_once __DIR__ . '/../config/db.php';
session_start();

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $response = $_POST['g-recaptcha-response'] ?? '';
    $secret = '6LfD5dErAAAAAJ6G5vt8u9AFmEwD0ozOldsDxfgm';

    if (!$response) {
        $error = "لطفاً کپچا را تکمیل کنید.";
    } else {
        // اعتبارسنجی کپچا
        $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';
        $data = [
            'secret' => $secret,
            'response' => $response,
            'remoteip' => $_SERVER['REMOTE_ADDR'] ?? null
        ];

        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ],
        ];
        $context  = stream_context_create($options);
        $result = file_get_contents($verifyUrl, false, $context);
        $resultJson = json_decode($result);

        if ($resultJson->success !== true) {
            $error = "اعتبارسنجی کپچا با مشکل مواجه شد.";
        }
    }

    if (!$error) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['phone_number'] = $user['phone_number'];
            header("Location: ../view/mainpage.php");
            exit();
        } else {
            $error = "ایمیل یا رمز عبور اشتباه است.";
        }
    }
}

// گرفتن لوگو از دیتابیس
$stmt = $pdo->query("SELECT images FROM logo LIMIT 1");
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$logoPath = "../uploads/" . $row['images'];
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>ورود - YounMarket</title>
    <link rel="stylesheet" href="../styles/auth_pages.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <header>
        <div class="logo">
            <img src="../images/xLogo.jpg" alt="لوگوی سایت">
        </div>

        <div class="title">
            <h1>Youn Market</h1>
        </div>

        <a href="admin_login.php" class="otherLogin"> ادمین هستید؟</a>
        
    </header>

    <div class="container-center">
        <div class="auth-container">
            <span class="auth-brand">YounMarket</span>
            <h2>ورود کاربران</h2>

            <?php if ($error): ?>
                <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <form method="post" autocomplete="on">
                <label>ایمیل:</label>
                <input type="email" name="email" required>

                <label>رمز:</label>
                <input type="password" name="password" required>

                <div class="g-recaptcha" data-sitekey="6LfD5dErAAAAAERcyJmbzLeEjnh16jl9ZlYkg1BA"></div>

                <button type="submit">ورود</button>

                <p style="text-align:center; margin-top:12px;">
                    حساب کاربری ندارید؟ <a href="signin.php">ثبت نام</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>
