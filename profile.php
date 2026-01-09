<?php
include __DIR__ . "/db/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit;
}

$id = $_SESSION['user_id'];
$result = mysqli_query($conn, "SELECT * FROM users WHERE id = $id");
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container py-5">

<h2>👤 My Profile</h2>

<form action="profile_update.php" method="POST" class="mb-4">
    <input class="form-control mb-2" name="name" value="<?php echo $user['name']; ?>" required>
    <input class="form-control mb-2" name="email" value="<?php echo $user['email']; ?>" required>
    <input class="form-control mb-2" name="phone" value="<?php echo $user['phone']; ?>">
    <button class="btn btn-primary w-100">Update Profile</button>
</form>

<form action="delete_account.php" method="POST"
      onsubmit="return confirm('Delete your account permanently?');">
    <button class="btn btn-danger w-100">🗑️ Delete My Account</button>
</form>

<a href="index.php" class="btn btn-link mt-3">← Back</a>

</div>
</body>
</html>
