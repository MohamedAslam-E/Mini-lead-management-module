<?php
session_start();

include('./database.php');

$username = $_POST['username'];
$password = $_POST['password'];

$sql_admin = "SELECT * FROM users WHERE username = '$username' AND user_type = 'admin'";
$result_admin = $conn->query($sql_admin);

$sql_employee = "SELECT * FROM users WHERE username = '$username' AND user_type = 'employee'";
$result_employee = $conn->query($sql_employee);

if ($result_admin->num_rows > 0) {
    // Admin found, verify password
    $row = $result_admin->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        // Password is correct, set session and redirect to admin dashboard
        $_SESSION['user_type'] = 'admin';
        header("Location: admin/admin_dashboard.php");
        exit();
    } else {
        $_SESSION['error_message'] = "The username or password you entered isn't connected to an admin account.";
        header("Location: index.php");
        exit();
    }
} elseif ($result_employee->num_rows > 0) {
    // Employee found, verify password
    $row = $result_employee->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        // Password is correct, set session and redirect to employee dashboard
        $_SESSION['user_type'] = 'employee';
        $_SESSION['user_id'] = $row['id'];
        header("Location: employee/employee_dashboard.php");
        exit();
    } else {
        $_SESSION['error_message'] = "The username or password you entered isn't connected to an employee account.";
        header("Location: index.php");
        exit();
    }
} else {
    $_SESSION['error_message'] = "User not found.";
    header("Location: index.php");
    exit();
}

mysqli_close($conn);
?>
