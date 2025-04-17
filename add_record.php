<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $wellness_score = mysqli_real_escape_string($conn, $_POST['wellness_score']);
    $comments = mysqli_real_escape_string($conn, $_POST['comments']);

    // Check if student_id exists
    $check_sql = "SELECT id FROM users WHERE id = '$student_id'";
    $check_result = mysqli_query($conn, $check_sql);
    if (mysqli_num_rows($check_result) == 0) {
        die("Error: Student ID $student_id does not exist in the users table!");
    }

    $sql = "INSERT INTO wellness_records (student_id, name, wellness_score, comments) 
            VALUES ('$student_id', '$name', '$wellness_score', '$comments')";
    if (mysqli_query($conn, $sql)) {
        header("Location: admin_dashboard.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Fetch user IDs for dropdown
$user_sql = "SELECT id, username FROM users";
$user_result = mysqli_query($conn, $user_sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Record</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Add Wellness Record</h2>
        <form method="POST">
            <select name="student_id" required>
                <option value="">Select Student ID</option>
                <?php while ($user = mysqli_fetch_assoc($user_result)) { ?>
                    <option value="<?php echo $user['id']; ?>"><?php echo $user['id'] . ' (' . $user['username'] . ')'; ?></option>
                <?php } ?>
            </select>
            <input type="text" name="name" placeholder="Name" required>
            <input type="number" name="wellness_score" placeholder="Wellness Score (0-100)" min="0" max="100" required>
            <textarea name="comments" placeholder="Comments"></textarea>
            <button type="submit">Add Record</button>
        </form>
    </div>
</body>
</html>