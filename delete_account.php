<?php
include __DIR__ . "/db/config.php";

$id = $_SESSION['user_id'];

mysqli_query($conn, "DELETE FROM users WHERE id=$id");

session_destroy();

header("Location: index.php");
exit;
