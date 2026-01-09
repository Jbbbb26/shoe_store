<?php
include __DIR__ . "/../db/config.php";

// must be logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$id = $_GET['id'];

// initialize cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// if product already in cart → increase quantity
if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]++;
} else {
    $_SESSION['cart'][$id] = 1;
}

header("Location: view.php");
