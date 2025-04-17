<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
}

$id = $_GET['id'];
$sql = "SELECT * FROM wellness_records WHERE id = $id";
$result = mysqli_query($conn, $sql);
$record = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $wellness_score = mysqli_real_escape_string($conn, $_POST['wellness_score']);
    $comments = mysqli_real_escape_string($conn, $_POST['comments']);

    $sql = "UPDATE wellness_records SET student_id='$student_id', name='$name', wellness_score='$wellness_score', comments='$comments' WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        header("Location: admin_dashboard.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Record</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Edit Wellness Record</h2>
        <form method="POST">
            <input type="number" name="student_id" value="<?php echo $record['student_id']; ?>" required>
            <input type="text" name="name" value="<?php echo $record['name']; ?>" required>
            <input type="number" name="wellness_score" value="<?php echo $record['wellness_score']; ?>" min="0" max="100" required>
            <textarea name="comments"><?php echo $record['comments']; ?></textarea>
            <button type="submit">Update Record</button>
        </form>
    </div>
</body>
</html>