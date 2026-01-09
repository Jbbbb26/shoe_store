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

$user_id = $_SESSION['user_id'];
$total = 0;

/* Calculate total */
foreach ($cart as $product_id => $qty) {
    $result = mysqli_query($conn, "SELECT price FROM products WHERE id = $product_id");
    $product = mysqli_fetch_assoc($result);
    if ($product) {
        $total += $product['price'] * $qty;
    }
}

/* Create order */
mysqli_query(
    $conn,
    "INSERT INTO orders (user_id, total) VALUES ($user_id, $total)"
);

$order_id = mysqli_insert_id($conn);

/* Insert order items */
foreach ($cart as $product_id => $qty) {
    $result = mysqli_query($conn, "SELECT price FROM products WHERE id = $product_id");
    $product = mysqli_fetch_assoc($result);

    if ($product) {
        $price = $product['price'];

        mysqli_query(
            $conn,
            "INSERT INTO order_items (order_id, product_id, price, quantity)
             VALUES ($order_id, $product_id, $price, $qty)"
        );
    }
}

/* Clear cart */
unset($_SESSION['cart']);

/* Redirect */
header("Location: orders.php");
exit;
