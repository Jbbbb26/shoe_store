<?php
include __DIR__ . "/db/config.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Shoe Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container py-5">

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>👟 Shoe Store</h1>

    <?php if (isset($_SESSION['user_name'])) { ?>
        <div class="d-flex align-items-center gap-2">
            👋 Hello, <strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong>

            <a href="profile.php" class="btn btn-sm btn-outline-primary">Profile</a>
            <a href="cart/view.php" class="btn btn-sm btn-outline-success">Cart</a>
            <a href="auth/logout.php" class="btn btn-sm btn-outline-dark">Logout</a>
        </div>
    <?php } else { ?>
        <a href="auth/login.php" class="btn btn-dark">Login</a>
    <?php } ?>
</div>

<div class="row">
<?php
$result = mysqli_query($conn, "SELECT * FROM products");

while ($row = mysqli_fetch_assoc($result)) {
?>
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
            <img src="images/<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top" style="height:250px; object-fit:cover;">
            <div class="card-body text-center">
                <h5><?php echo htmlspecialchars($row['name']); ?></h5>
                <p class="fw-bold text-success">₱<?php echo number_format($row['price'], 2); ?></p>
                <a href="cart/add.php?id=<?php echo $row['id']; ?>" class="btn btn-dark w-100">Add to Cart</a>
            </div>
        </div>
    </div>
<?php } ?>
</div>

</div>
</body>
</html>
