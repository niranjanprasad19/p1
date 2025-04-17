<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
}

$id = $_GET['id'];
$sql = "DELETE FROM wellness_records WHERE id = $id";
if (mysqli_query($conn, $sql)) {
    header("Location: admin_dashboard.php");
} else {
    echo "Error: " . mysqli_error($conn);
}
?>