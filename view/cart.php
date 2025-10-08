<?php
session_start();
include('../layout/header.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: ../registeration/login.php");
    exit;
} else {
    $firstNameInSession = $_SESSION['first_name'];
    $phoneNum = $_SESSION['phone_number'];
}

$cart = $_SESSION['cart'] ?? [];
?>

<h2>سبد خرید شما <?php echo htmlspecialchars($firstNameInSession); ?> عزیز</h2>
<h3>شماره تماس: <?php echo htmlspecialchars($phoneNum) ?></h3>

<?php if (empty($cart)): ?>
    <p>سبد خرید خالی است.</p>
<?php else: ?>
    <table class="cart-table">
        <tr>
            <th>نام کالا</th>
            <th>تعداد</th>
            <th>قیمت واحد</th>
            <th>قیمت کل</th>
            <th>عملیات</th>
        </tr>
        <?php
        $total = 0;
        foreach ($cart as $id => $item):
            $subtotal = $item['quantity'] * $item['price'];
            $total += $subtotal;
        ?>
            <tr>
                <td><?= htmlspecialchars($item['name']) ?></td>
                <td><?= $item['quantity'] ?></td>
                <td><?= $item['price'] ?> تومان</td>
                <td><?= $subtotal ?> تومان</td>
                <td>
                    <button class="btn small" data-id="<?= $id ?>" data-action="increase">+</button>
                    <button class="btn small" data-id="<?= $id ?>" data-action="decrease">-</button>
                    <button class="btn small danger" data-id="<?= $id ?>" data-action="remove">حذف</button>
                </td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3"><strong>جمع کل:</strong></td>
            <td colspan="2"><?= $total ?> تومان</td>
        </tr>
    </table>
<?php endif; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $(".btn").click(function() {
            const itemId = $(this).data("id");
            const action = $(this).data("action");

            $.post("../public/update_cart.php", {
                id: itemId,
                action: action
            }, function(response) {
                alert(response);
                location.reload();
            });
        });
    });
</script>

<?php if (!empty($cart)): ?>
    <form action="../public/submit_order.php" method="POST">
        <label for="delivery_date">تاریخ ارسال:</label>
        <input type="date" id="delivery_date" name="delivery_date" required>
        <button type="submit" class="btn">ثبت سفارش</button>
    </form>
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