    <?php
include __DIR__ . "/../db/config.php";
    session_destroy();
    header("Location: login.php");
