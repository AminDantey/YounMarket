<?php
require '../config/db.php';
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php if (!empty($page_css)): ?>
        <link rel="stylesheet" href="<?php echo $page_css; ?>">
    <?php else: ?>
        <link rel="stylesheet" href="../styles/mainpage_style.css">
    <?php endif; ?>
    <title>YounMarket</title>
</head>
<body>
    <header class="mainpage-header">
        <div class="logo">🛍️ YounMarket</div>
        <nav class="main-nav">
            <a href="mainpage.php">خانه</a>
            <a href="cart.php">سبد خرید</a>
            <form method="post" action="../registeration/logout.php" style="display:inline;">
                <button type="submit" class="btn logout-btn">خروج</button>
            </form>
        </nav>
    </header>
    <main class="site-content">
