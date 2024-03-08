<?php
$db_server = "localhost";
$db_user = "root";
$db_ps = "";
$db_name = "lead";

$conn = mysqli_connect($db_server, $db_user, $db_ps, $db_name);

if ($conn) {

    // Check if admin user exists
    $admin_check_sql = "SELECT * FROM users WHERE username = 'admin' AND user_type = 'admin'";
    $admin_result = $conn->query($admin_check_sql);
    if ($admin_result->num_rows == 0) {
        // Admin user doesn't exist, insert
        $admin_insert_sql = "INSERT INTO users (username, password, user_type) VALUES ('admin', '" . password_hash('admin123', PASSWORD_DEFAULT) . "', 'admin')";
        if ($conn->query($admin_insert_sql) === TRUE) {
            echo "Admin user created successfully<br>";
        } else {
            echo "Error creating admin user: " . $conn->error . "<br>";
        }
    }

    // Check if employee users exist
    $employees = array(
        array('employee1', password_hash('employee1123', PASSWORD_DEFAULT), 'employee'),
        array('employee2', password_hash('employee2123', PASSWORD_DEFAULT), 'employee')
    );

    foreach ($employees as $employee) {
        $employee_username = $employee[0];
        $employee_check_sql = "SELECT * FROM users WHERE username = '$employee_username' AND user_type = 'employee'";
        $employee_result = $conn->query($employee_check_sql);
        if ($employee_result->num_rows == 0) {
            // Employee user doesn't exist, insert
            $sql_employee = "INSERT INTO users (username, password, user_type) VALUES ('$employee[0]', '$employee[1]', '$employee[2]')";
            if ($conn->query($sql_employee) === TRUE) {
                echo "Employee user created successfully: $employee[0]<br>";
            } else {
                echo "Error creating employee user: " . $conn->error . "<br>";
            }
        }
    }
} else {
    echo " server busy";
}
