<?php
session_start();
$_POST['admin'] = true;
require '../config/db.php';
include('../layout/header.php');

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../registeration/admin_login.php");
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: adminpage.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM items WHERE id = ?");
$stmt->execute([$id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$item) {
    die("آیتم پیدا نشد!");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $price = trim($_POST['price']);
    $description = trim($_POST['description']);
    $imageName = $item['image'];

    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . "_" . basename($_FILES['image']['name']);
        $targetPath = "../uploads/" . $imageName;
        move_uploaded_file($_FILES['image']['tmp_name'], $targetPath);
    }

    $stmt = $pdo->prepare("UPDATE items SET name=?, price=?, description=?, image=? WHERE id=?");
    $stmt->execute([$name, $price, $description, $imageName, $id]);

    header("Location: adminpage.php");
    exit;
}
?>
<div style="
    max-width: 400px;
    margin: 40px auto;
    background: #fff;
    padding: 25px 30px;
    border-radius: 15px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    font-family: sans-serif;
    direction: rtl;
">
    <h2 style="
        text-align: center;
        color: #3C467B;
        margin-bottom: 25px;
    ">✏️ ویرایش آیتم</h2>

    <form method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 15px;">
        <label>نام:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($item['name']) ?>" required
               style="padding: 8px 10px; border: 1px solid #ccc; border-radius: 8px;">

        <label>قیمت:</label>
        <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($item['price']) ?>" required
               style="padding: 8px 10px; border: 1px solid #ccc; border-radius: 8px;">

        <label>توضیحات:</label>
        <textarea name="description" style="padding: 8px 10px; border: 1px solid #ccc; border-radius: 8px; resize: vertical;"><?= htmlspecialchars($item['description']) ?></textarea>

        <label>عکس فعلی:</label>
        <?php if ($item['image']): ?>
            <img src="../uploads/<?= htmlspecialchars($item['image']) ?>" width="120" style="border-radius: 10px; margin-bottom: 5px;">
        <?php else: ?>
            <span style="color: gray;">بدون عکس</span>
        <?php endif; ?>

        <label>تغییر عکس:</label>
        <input type="file" name="image" accept="image/*"
               style="border: 1px solid #ccc; padding: 6px; border-radius: 8px; background: #fafafa;">

        <button type="submit" class="btn" style="
            background: #3C467B;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.2s;
        ">💾 ذخیره تغییرات</button>
    </form>

    <a href="adminpage.php" class="btn danger" style="
        display: inline-block;
        margin-top: 15px;
        text-align: center;
        background: #e74c3c;
        color: #fff;
        padding: 10px;
        border-radius: 8px;
        text-decoration: none;
        width: 100%;
    ">⬅️ بازگشت</a>
</div>




