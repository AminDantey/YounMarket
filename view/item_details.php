<?php
session_start();
$page_css = '../styles/mainpage_style.css'; // CSS اختصاصی
include('../layout/mainheader.php'); // هدر مشابه mainpage

if (!isset($_SESSION['user_id'])) {
    header("Location: ../registeration/login.php");
    exit;
}else $firstNameInSession = $_SESSION['first_name'] ?? '';



$item = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM items WHERE id = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch();
}
?>

<!-- نمایش اسم کاربر -->
<div class="welcome-bar" style="margin-top:20px;">
    <h4>👋 <?= htmlspecialchars($firstNameInSession) ?> عزیز، اطلاعات کتاب زیر:</h4>
</div>

<?php if (!empty($item)): ?>
    <div class="item-details">
        <h2><?= htmlspecialchars($item['name']) ?></h2>
        <p><strong>✍️ نویسنده:</strong> <?= htmlspecialchars($item['writer']) ?></p>
        <p><?= htmlspecialchars($item['description']) ?></p>
        <img src="../uploads/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
        <p><strong>📦 موجودی:</strong> <?= htmlspecialchars($item['stock']) ?></p>
        <p><strong>💰 قیمت:</strong> <?= htmlspecialchars($item['price']) ?> تومان</p>
        <a href="mainpage.php" class="btn">⬅️ بازگشت به فروشگاه</a>
    </div>
<?php else: ?>
    <p style="text-align:center; color:red; margin-top:50px;">❌ کتاب پیدا نشد.</p>
    <a href="mainpage.php" class="btn">⬅️ بازگشت به فروشگاه</a>
<?php endif; ?>

</main>
<footer style="
    width: 100%;
    background: linear-gradient(90deg, #50589C, #3C467B, #6E8CFB);
    color: #fff;
    text-align: center;
    padding: 18px 0;
    font-size: 1rem;
    position: fixed;
    left: 0;
    bottom: 0;
    z-index: 100;
    box-shadow: 0 -2px 8px rgba(0, 0, 0, 0.08);
    letter-spacing: 1px;">
    © 2025 .YounMarket. All rights reserved
</footer>