<?php
require_once __DIR__ . '/../config/db.php';
session_start();
$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $response = $_POST['g-recaptcha-response'] ?? '';
    $secret = '6LfD5dErAAAAAJ6G5vt8u9AFmEwD0ozOldsDxfgm';

    if (!$response) {
        $error = "لطفاً کپچا را تکمیل کنید.";
    } else {
        // اعتبارسنجی کپچا سمت سرور
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
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE username=?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['admin_id'];
            $_SESSION['username'] = $admin['username'];
            $_SESSION['first_name'] = $admin['first_name'];
            header("Location: ../view/adminpage.php");
            exit();
        } else {
            $error = "نام کاربری یا رمز اشتباه است.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>ورود مدیر - YounMarket</title>
    <link rel="stylesheet" href="../styles/auth_pages.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <header>

        <div class="logo">
            <img src="../images/xLogo.jpg" alt="لوگوی سایت" height="60">
        </div>
        <div class="title">
            <h1>Youn Market</h1>
        </div>
        <a href="login.php" class="otherLogin">کاربر هستید؟</a>
    </header>

<div class="container-center">
    <div class="auth-container">
        <span class="auth-brand">YounMarket</span>
        <h2>ورود مدیر</h2>

        <?php if ($error): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form method="post" autocomplete="on">
            <label>نام کاربری:</label>
            <input type="text" name="username" required>

            <label>رمز عبور:</label>
            <input type="password" name="password" required>

            <div class="g-recaptcha" data-sitekey="6LfD5dErAAAAAERcyJmbzLeEjnh16jl9ZlYkg1BA"></div>

            <button type="submit">ورود</button>
        </form>
    </div>
</div>
</body>
</html>
