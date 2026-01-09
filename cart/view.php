<?php
include __DIR__ . "/../db/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$cart = $_SESSION['cart'] ?? [];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container py-5">

<h2 class="mb-4">🛒 Your Cart</h2>

<?php if (empty($cart)) { ?>
    <div class="alert alert-info">Your cart is empty.</div>
    <a href="../index.php" class="btn btn-dark">Back to Shop</a>
<?php } else { ?>

<table class="table table-bordered bg-white align-middle">
    <thead>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th width="180">Qty</th>
            <th>Total</th>
            <th width="100">Action</th>
        </tr>
    </thead>
    <tbody>

<?php
$grandTotal = 0;

foreach ($cart as $product_id => $qty) {
    $result = mysqli_query($conn, "SELECT * FROM products WHERE id = $product_id");
    $product = mysqli_fetch_assoc($result);

    if (!$product) continue;

    $total = $product['price'] * $qty;
    $grandTotal += $total;
?>
<tr>
    <td><?php echo htmlspecialchars($product['name']); ?></td>
    <td>₱<?php echo number_format($product['price'], 2); ?></td>

    <!-- UPDATE QTY -->
    <td>
        <form action="update.php" method="POST" class="d-flex gap-2">
            <input type="hidden" name="id" value="<?php echo $product_id; ?>">
            <input type="number" name="qty" value="<?php echo $qty; ?>" min="1" class="form-control">
            <button class="btn btn-primary btn-sm">Update</button>
        </form>
    </td>

    <td>₱<?php echo number_format($total, 2); ?></td>

    <!-- REMOVE -->
    <td>
        <a href="remove.php?id=<?php echo $product_id; ?>" 
           class="btn btn-danger btn-sm"
           onclick="return confirm('Remove this item?')">
           ❌ Remove
        </a>
    </td>
</tr>
<?php } ?>

    </tbody>
</table>

<h4 class="text-end">Grand Total: ₱<?php echo number_format($grandTotal, 2); ?></h4>

<div class="d-flex justify-content-between mt-4">
    <a href="../index.php" class="btn btn-secondary">
        ← Continue Shopping
    </a>

    <a href="../checkout.php" class="btn btn-success">
        💳 Proceed to Checkout
    </a>
</div>

<?php } ?>

</div>
</body>
</html>
