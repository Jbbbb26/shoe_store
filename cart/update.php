<?php
session_start();

$id = $_POST['id'];
$qty = (int)$_POST['qty'];

if ($qty > 0) {
    $_SESSION['cart'][$id] = $qty;
}

header("Location: view.php");
exit;
