<?php
include __DIR__ . "/db/config.php";

$id = $_SESSION['user_id'];

mysqli_query($conn, "
    UPDATE users 
    SET 
        name='{$_POST['name']}',
        email='{$_POST['email']}',
        phone='{$_POST['phone']}'
    WHERE id=$id
");

$_SESSION['user_name'] = $_POST['name'];

header("Location: profile.php");
exit;
