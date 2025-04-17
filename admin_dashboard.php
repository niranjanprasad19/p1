<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
}

$sql = "SELECT * FROM wellness_records";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Welcome, Admin!</h2>
        <a href="logout.php">Logout</a>
        <h3>Student Wellness Records</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Wellness Score</th>
                <th>Comments</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['wellness_score']; ?></td>
                <td><?php echo $row['comments']; ?></td>
                <td>
                    <a href="edit_record.php?id=<?php echo $row['id']; ?>">Edit</a> |
                    <a href="delete_record.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>