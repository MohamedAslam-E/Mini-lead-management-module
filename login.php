<?php
session_start();

$db_server = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "lead";

$conn = mysqli_connect($db_server, $db_user, $db_password, $db_name);

// Check connection
if (!$conn) {
    die(" db Connection failed");
}

$username = $_POST['username'];
$password = $_POST['password'];
$user_type = $_POST['user_type'];

$sql = "SELECT * FROM users WHERE username = '$username' AND user_type = '$user_type'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // User found, verify password and user type
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password']) && $row['user_type'] == $user_type) {
        // Password and user type are correct, set session and redirect
        $_SESSION['user_type'] = $user_type;
        $_SESSION['user_id'] = $row['id'];
        if ($user_type == 'admin') {
            header("Location: admin/admin_dashboard.php");
        } elseif ($user_type == 'employee') {
            header("Location: employee/employee_dashboard.php");
        }
    } else {
        echo "The username or password or user type you entered isn't connected to an account.";
    }
} else {
    echo "User not found";
}

mysqli_close($conn);
