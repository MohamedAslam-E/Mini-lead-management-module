<?php
session_start();
include('../database.php');

if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'admin') {
    // Check if lead ID is provided in the URL
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $lead_id = $_GET['id'];

        // Fetch lead details
        $sql = "SELECT * FROM leads WHERE id = $lead_id";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Handle form submission
                $name = $_POST['name'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $status = $_POST['status'];
                $assigned_to = $_POST['assigned_to'];

                // Update lead details
                $update_sql = "UPDATE leads SET name = '$name', email = '$email', phone = '$phone', status = '$status', assigned_to = '$assigned_to' WHERE id = $lead_id";

                if (mysqli_query($conn, $update_sql)) {
                    header('Location:admin_dashboard.php');
                    exit();
                } else {
                    echo "Error updating lead: " . mysqli_error($conn);
                }
            }
        } else {
            echo "Lead not found";
        }
    } else {
        echo "Lead ID not provided";
    }
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Update Lead</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css" />
    </head>

    <body>
        <div class="container mt-5">
            <h1>Update Lead</h1>
            <a href="admin_dashboard.php" class="btn btn-primary">Back to Dashboard</a><br><br>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=$lead_id"; ?>">
                <label for="name" class="form-label">Name:</label><br>
                <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" class="form-control" required><br>
                <label for="email" class="form-label">Email:</label><br>
                <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" class="form-control" required><br>
                <label for="phone" class="form-label">Phone:</label><br>
                <input type="text" id="phone" name="phone" value="<?php echo $row['phone']; ?>" class="form-control" required><br>
                <label for="status" class="form-label">Status:</label><br>
                <select id="status" name="status" class="form-select">
                    <option value="new" <?php if ($row['status'] == 'new') echo 'selected'; ?>>New</option>
                    <option value="contacted" <?php if ($row['status'] == 'contacted') echo 'selected'; ?>>Contacted</option>
                    <option value="follow-up" <?php if ($row['status'] == 'follow-up') echo 'selected'; ?>>Follow-up</option>
                    <option value="converted" <?php if ($row['status'] == 'converted') echo 'selected'; ?>>Converted</option>
                    <option value="closed" <?php if ($row['status'] == 'closed') echo 'selected'; ?>>Closed</option>
                </select><br>
                <label for="assigned_to" class="form-label">Assigned To:</label><br>
                <select id="assigned_to" name="assigned_to" class="form-select">
                    <?php
                    $employee_query = "SELECT * FROM users WHERE user_type = 'employee'";
                    $employee_result = mysqli_query($conn, $employee_query);
                    if ($employee_result->num_rows > 0) {
                        while ($employee_row = mysqli_fetch_assoc($employee_result)) {
                            echo "<option value='" . $employee_row['id'] . "'";
                            if ($row['assigned_to'] == $employee_row['id']) {
                                echo " selected";
                            }
                            echo ">" . $employee_row['username'] . "</option>";
                        }
                    }
                    ?>
                </select><br>
                <button type="submit" class="btn btn-primary mt-3">Update Lead</button>
            </form>
        </div>
    </body>

    </html>

<?php
} else {
    header("Location: ../index.php");
    mysqli_close($conn);
}
?>