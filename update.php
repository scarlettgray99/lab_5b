<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli('localhost:3307', 'root', '', 'webdev_lab5b');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM users WHERE id=$id");
    $user = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $role = $_POST['role'];

    $conn->query("UPDATE users SET matric='$matric', name='$name', role='$role' WHERE id=$id");
    header("Location: display.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Update User</h2>
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
            <div class="mb-3">
                <label>Matric:</label>
                <input type="text" name="matric" value="<?php echo $user['matric']; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Name:</label>
                <input type="text" name="name" value="<?php echo $user['name']; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Access Level:</label>
                <input type="text" name="role" value="<?php echo $user['role']; ?>" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="display.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>

<?php $conn->close(); ?>
