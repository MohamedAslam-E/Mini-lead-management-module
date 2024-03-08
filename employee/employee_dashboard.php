<?php
session_start();
include('../database.php');

if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'employee') {
    $employee_id = $_SESSION['user_id'];

    // Fetch leads assigned to the employee
    $sql = "SELECT * FROM leads WHERE assigned_to = $employee_id";
    $result = mysqli_query($conn, $sql);

    mysqli_close($conn);
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Employee Dashboard</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css" />
    </head>

    <body>
        <div class="container">
            <h1 class="mt-5">Welcome Employee</h1>
            <div class=" d-flex justify-content-end">
                <a href="../logout.php" class="btn btn-warning text-white mt-3">Logout</a>
            </div>
            <h2 class="mt-4">My Leads</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row["id"] . "</td>";
                            echo "<td>" . $row["name"] . "</td>";
                            echo "<td>" . $row["email"] . "</td>";
                            echo "<td>" . $row["phone"] . "</td>";
                            echo "<td>" . $row["status"] . "</td>";
                            echo "<td><a href='update_status.php?id=" . $row["id"] . "' class='btn btn-primary'>Update Status</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No leads assigned</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </body>

    </html>

<?php
} else {
    header("Location: ../index.php");
}
?>