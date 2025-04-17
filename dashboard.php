<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: login.php");
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM wellness_records WHERE student_id = $user_id";
$result = mysqli_query($conn, $sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $wellness_score = mysqli_real_escape_string($conn, $_POST['wellness_score']);
    $comments = mysqli_real_escape_string($conn, $_POST['comments']);

    $sql = "INSERT INTO wellness_records (student_id, name, wellness_score, comments) 
            VALUES ('$user_id', '$name', '$wellness_score', '$comments')";
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
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Welcome, Student!</h2>
        <a href="logout.php">Logout</a>
        <h3>Add New Wellness Record</h3>
        <form method="POST">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="number" name="wellness_score" placeholder="Wellness Score (0-100)" min="0" max="100" required>
            <textarea name="comments" placeholder="Comments"></textarea>
            <button type="submit">Add Record</button>
        </form>
        <h3>Your Wellness Records</h3>
        <table>
            <tr>
                <th>Name</th>
                <th>Wellness Score</th>
                <th>Comments</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['wellness_score']; ?></td>
                <td><?php echo $row['comments']; ?></td>
                <td>
                    <a href="student_edit_record.php?id=<?php echo $row['id']; ?>">Edit</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>