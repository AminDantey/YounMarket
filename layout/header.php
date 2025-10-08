<?php
require '../config/db.php';
if (empty($_POST['admin']) || $_POST['admin'] != true)
 { ?>

    <!DOCTYPE html>
    <html lang="fa" dir="rtl">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <?php if (!empty($page_css)): ?>
            <link rel="stylesheet" href="<?php echo $page_css; ?>">
        <?php else: ?>
            <link rel="stylesheet" href="../styles/style.css">
        <?php endif; ?>
    </head>

    <body>
        <header class="site-header">
            <div class="logo">🛍️ YounMarket</div>
            <nav class="main-nav">
                <a href="mainpage.php">خانه</a>
                <a href="cart.php">سبد خرید</a>
                <a href="my_orders.php">سفارش‌ها</a>
                <a href="../registeration/logout.php">خروج</a>
            </nav>
        </header>
        <main class="site-content">




        <?php
    } 
    else {?>

        <!DOCTYPE html>
        <html lang="fa" dir="rtl">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <?php if (!empty($page_css)): ?>
                <link rel="stylesheet" href="<?php echo $page_css; ?>">
            <?php else: ?>
                <link rel="stylesheet" href="../styles/style.css">
            <?php endif; ?>
        </head>

        <body>
            <header class="site-header">
                <div class="logo">🛍️ YounMarket</div>
                <nav class="main-nav">
                    <a href="../view/adminpage.php">صفحه آیتم ها</a>
                </nav>
            </header>
            <main class="site-content">

            <?php } ?>