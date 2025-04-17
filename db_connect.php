<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "student_wellness_db";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error() . " (Error number: " . mysqli_connect_errno() . ")");
}
?>