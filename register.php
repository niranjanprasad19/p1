<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); // Plain text

    // Check if username already exists
    $check_sql = "SELECT * FROM users WHERE username='$username'";
    $check_result = mysqli_query($conn, $check_sql);
    if (mysqli_num_rows($check_result) > 0) {
        echo "Username already exists!";
    } else {
        $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', 'student')";
        if (mysqli_query($conn, $sql)) {
            header("Location: login.php");
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js"></script>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form method="POST" onsubmit="return validateRegisterForm()">
            <input type="text" id="username" name="username" placeholder="Username" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
</body>
</html>