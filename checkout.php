<?php
include __DIR__ . "/db/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit;
}

$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    header("Location: cart/view.php");
    exit;
}

$total = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container py-5">

<h2 class="mb-4">💳 Checkout</h2>

<table class="table table-bordered bg-white">
    <thead>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>

<?php
foreach ($cart as $product_id => $qty) {
    $result = mysqli_query($conn, "SELECT * FROM products WHERE id = $product_id");
    $product = mysqli_fetch_assoc($result);

    if (!$product) continue;

    $subtotal = $product['price'] * $qty;
    $total += $subtotal;
?>
        <tr>
            <td><?php echo htmlspecialchars($product['name']); ?></td>
            <td>₱<?php echo number_format($product['price'], 2); ?></td>
            <td><?php echo $qty; ?></td>
            <td>₱<?php echo number_format($subtotal, 2); ?></td>
        </tr>
<?php } ?>

    </tbody>
</table>

<h4 class="text-end">Total: ₱<?php echo number_format($total, 2); ?></h4>

<form action="place_order.php" method="POST">
    <button class="btn btn-success w-100 mt-3">
        ✅ Place Order
    </button>
</form>

<a href="cart/view.php" class="btn btn-link mt-3">← Back to Cart</a>

</div>
</body>
</html>
