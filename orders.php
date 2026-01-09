<?php
include __DIR__ . "/db/config.php";

// login required
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// get user orders
$orders = mysqli_query(
    $conn,
    "SELECT * FROM orders WHERE user_id = $user_id ORDER BY created_at DESC"
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container py-5">

<h2 class="mb-4">📦 My Orders</h2>

<?php if (mysqli_num_rows($orders) == 0) { ?>
    <div class="alert alert-info">
        You have no orders yet.
    </div>
    <a href="index.php" class="btn btn-dark">Start Shopping</a>

<?php } else { ?>

<?php while ($order = mysqli_fetch_assoc($orders)) { ?>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between">
        <strong>Order #<?php echo $order['id']; ?></strong>
        <span><?php echo $order['status']; ?></span>
    </div>

    <div class="card-body">
        <p>
            <strong>Date:</strong>
            <?php echo $order['created_at']; ?>
        </p>

        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>

            <?php
            $items = mysqli_query(
                $conn,
                "SELECT oi.*, p.name 
                 FROM order_items oi
                 JOIN products p ON oi.product_id = p.id
                 WHERE oi.order_id = {$order['id']}"
            );

            while ($item = mysqli_fetch_assoc($items)) {
                $itemTotal = $item['price'] * $item['quantity'];
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td>₱<?php echo number_format($item['price'], 2); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>₱<?php echo number_format($itemTotal, 2); ?></td>
                </tr>
            <?php } ?>

            </tbody>
        </table>

        <h5 class="text-end">
            Order Total: ₱<?php echo number_format($order['total'], 2); ?>
        </h5>
    </div>
</div>

<?php } } ?>

<a href="index.php" class="btn btn-secondary">
    ← Back to Shop
</a>

</div>
</body>
</html>
