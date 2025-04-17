<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: login.php");
}

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Check if the record belongs to the logged-in student
$sql = "SELECT * FROM wellness_records WHERE id = $id AND student_id = $user_id";
$result = mysqli_query($conn, $sql);
$record = mysqli_fetch_assoc($result);

if (!$record) {
    die("Error: You do not have permission to edit this record!");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $wellness_score = mysqli_real_escape_string($conn, $_POST['wellness_score']);
    $comments = mysqli_real_escape_string($conn, $_POST['comments']);

    $sql = "UPDATE wellness_records SET name='$name', wellness_score='$wellness_score', comments='$comments' WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        header("Location: dashboard.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Wellness Record</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Edit Wellness Record</h2>
        <form method="POST">
            <input type="text" name="name" value="<?php echo $record['name']; ?>" required>
            <input type="number" name="wellness_score" value="<?php echo $record['wellness_score']; ?>" min="0" max="100" required>
            <textarea name="comments"><?php echo $record['comments']; ?></textarea>
            <button type="submit">Update Record</button>
        </form>
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>