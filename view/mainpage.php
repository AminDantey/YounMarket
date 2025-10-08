<?php
session_start();
$page_css = '../styles/mainpage_style.css';
include('../layout/mainheader.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: ../registeration/login.php");
    exit;
} else {
    $firstNameInSession = $_SESSION['first_name'];
}

// دریافت آیتم‌ها
$stmt = $pdo->query('SELECT * FROM items');
$items = $stmt->fetchAll();
?>

<div class="main-content">
    <div class="welcome-bar">
        <h4>👋 <?= htmlspecialchars($firstNameInSession) ?> عزیز خوش آمدی</h4>
        <a class="btn" href="cart.php">🛒 سبد خرید</a>
    </div>
    <div class="bodysite">
        <h2 class="book-list">📚 لیست کتاب‌ها</h2>
        <div class="items-container">
            <?php foreach ($items as $item): ?>
                <div class="item-card">
                    <img src="../uploads/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                    <h3><?= htmlspecialchars($item['name']) ?></h3>
                    <p>💰 <?= htmlspecialchars($item['price']) ?> تومان</p>
                    <a href="item_details.php?id=<?= $item['id'] ?>" class="btn">🔎 مشخصات</a>
                    <button class="btn add-to-cart" data-id="<?= $item['id'] ?>">➕ خرید</button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<footer class="footer">
    &copy; <?php echo date('Y'); ?> .YounMarket. All rights reserved
</footer>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.add-to-cart').click(function() {
            const itemId = $(this).data('id');
            $.post("../public/add_to_cart.php", {
                id: itemId
            }, function(response) {
                alert(response);
            }).fail(function(xhr) {
                alert('خطا: ' + xhr.responseText);
            });
        });
    });
</script>