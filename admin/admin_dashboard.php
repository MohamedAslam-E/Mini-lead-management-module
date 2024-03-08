<?php
session_start();
include('../database.php');
if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'admin') {
    $sql = "SELECT leads.*, users.username AS assigned_username FROM leads LEFT JOIN users ON leads.assigned_to = users.id";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Dashboard</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css" />
    </head>

    <body>
        <div class="container">
            <h1 class="mt-5">Welcome Admin</h1>
            <div class=" d-flex justify-content-end">
                <a href="../logout.php" class="btn btn-warning text-white mt-3">Logout</a>
            </div>
            <h2 class="mt-4">Lead List</h2>
            <a href="lead.php" class="btn btn-success mb-3">Add Lead</a>

            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Assigned To</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                            <tr>
                                <td><?php echo $row["id"]; ?></td>
                                <td><?php echo $row["name"]; ?></td>
                                <td><?php echo $row["email"]; ?></td>
                                <td><?php echo $row["phone"]; ?></td>
                                <td><?php echo $row["status"]; ?></td>
                                <td><?php echo $row["assigned_username"]; ?></td>
                                <td>
                                    <a href='update_lead.php?id=<?php echo $row["id"]; ?>' class="btn btn-primary">Update</a> |
                                    <a onclick='return customConfirm("Are you sure you want to delete this?")' href='delete_lead.php?id=<?php echo $row["id"]; ?>' class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='7'>No leads found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <script>
            function customConfirm(message) {
                return confirm(message);
            }
        </script>
    </body>

    </html>

<?php
} else {
    header("Location: ../index");
}
?>