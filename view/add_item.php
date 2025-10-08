<?php
session_start();
require '../config/db.php';
$_POST['admin'] = true;
include('../layout/header.php');


if (!isset($_SESSION['admin_id'])) {
    header("Location: ../registeration/admin_login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $writer = trim($_POST['writer']);
    $price = trim($_POST['price']);
    $stock = trim($_POST['stock']);
    $description = trim($_POST['description']);

    $imageName = null;
    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . "_" . basename($_FILES['image']['name']);
        $targetPath = "../uploads/" . $imageName;
        move_uploaded_file($_FILES['image']['tmp_name'], $targetPath);
    }

    $stmt = $pdo->prepare("INSERT INTO items (name, writer, stock, price, description, image) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $writer, $stock, $price, $description, $imageName]);

    header("Location: adminpage.php");
    exit;
}
?>

<h2>➕ افزودن آیتم جدید</h2>
<form method="POST" enctype="multipart/form-data" class="form">
    <label>نام:</label>
    <input type="text" name="name" required>

    <label>نویسنده:</label>
    <input type="text" name="writer" required>

    <label>تعداد:</label>
    <input type="number" name="stock" required>

    <label>قیمت:</label>
    <input type="number" step="0.01" name="price" required>

    <label>توضیحات:</label>
    <textarea name="description"></textarea>

    <label>عکس:</label>
    <input type="file" name="image" accept="image/*">

    <button type="submit" class="btn">ثبت</button>
</form>
<a href="adminpage.php" class="btn danger">⬅️ بازگشت</a>

