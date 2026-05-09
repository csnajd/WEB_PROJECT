<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}
require_once __DIR__ . '/../includes/db.php';

$id = (int)$_GET['id'];
mysqli_query($conn, "DELETE FROM places WHERE id = $id");
header('Location: dashboard.php?msg=deleted');
exit();
?>