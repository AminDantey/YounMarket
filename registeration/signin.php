<?php
require_once __DIR__ . '/../config/db.php';
$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $first = trim($_POST['first_name'] ?? '');
    $last = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $phone = trim($_POST['phone_number'] ?? '');
    $age = trim($_POST['age'] ?? '');

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $error = "این ایمیل قبلاً ثبت شده است.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users(first_name,last_name,email,password,phone_number,age) VALUES(?,?,?,?,?,?)");
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $stmt->execute([$first, $last, $email, $hashed_password, $phone, $age]);
        header("Location: signin_result.php");
        exit();
    }
}
?>
<!DOCTYPE html>

<head>
    <title>register</title>
    <link rel="stylesheet" href="../styles/auth_pages.css">
</head>

<body>
    <div class="container-center">
        <div class="auth-container">
            <span class="auth-brand">YounMarket</span>
            <form method="post" name="sign_in" action="signin.php">

                <label for="first_name">نام:</label>
                <input type="text" id="first_name" name="first_name" required>

                <label for="last_name">نام خانوادگی:</label>
                <input type="text" id="last_name" name="last_name" required>

                <label for="email">ایمیل:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">رمز:</label>
                <input type="password" id="password" name="password" required>

                <label for="phone_number">شماره تماس:</label>
                <input type="tel" id="phone_number" name="phone_number" required>

                <label for="age">سن:</label>
                <input type="number" id="age" name="age" min="0" max="99" required>

                <button type="submit">ثبت نام</button>
                <p>حساب کاربری دارید؟ <a href="login.php">ورود به حساب</a></p>
        </div>
    </div>
</body>