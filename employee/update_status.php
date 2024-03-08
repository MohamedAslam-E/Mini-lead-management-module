<?php
session_start();
include('../database.php');

if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'employee') {
    $employee_id = $_SESSION['user_id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Handle form submission to update status
        $lead_id = $_POST['lead_id'];
        $status = $_POST['status'];

        $update_sql = "UPDATE leads SET status = '$status' WHERE id = $lead_id AND assigned_to = $employee_id";

        if (mysqli_query($conn, $update_sql)) {
            header('Location:employee_dashboard.php');
            exit();
        } else {
            echo "Error updating status: " . mysqli_error($conn);
        }
    } else {
        // Fetch lead details
        $lead_id = $_GET['id'];
        $lead_sql = "SELECT * FROM leads WHERE id = $lead_id AND assigned_to = $employee_id";
        $lead_result = mysqli_query($conn, $lead_sql);

        if ($lead_result->num_rows == 1) {
            $row = mysqli_fetch_assoc($lead_result);
?>

            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Update Status</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css" />
            </head>

            <body>
                <div class="container">
                    <h1 class="mt-5">Update Status</h1>
                    <a href="employee_dashboard.php" class="btn btn-primary mt-3">Back to Dashboard</a>

                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="mt-3">
                        <input type="hidden" name="lead_id" value="<?php echo $row['id']; ?>">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name:</label>
                            <input type="text" id="name" class="form-control" value="<?php echo $row['name']; ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="text" id="email" class="form-control" value="<?php echo $row['email']; ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone:</label>
                            <input type="text" id="phone" class="form-control" value="<?php echo $row['phone']; ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status:</label>
                            <select id="status" name="status" class="form-select">
                                <option value="new" <?php if ($row['status'] == 'new') echo 'selected'; ?>>New</option>
                                <option value="contacted" <?php if ($row['status'] == 'contacted') echo 'selected'; ?>>Contacted</option>
                                <option value="follow-up" <?php if ($row['status'] == 'follow-up') echo 'selected'; ?>>Follow-up</option>
                                <option value="converted" <?php if ($row['status'] == 'converted') echo 'selected'; ?>>Converted</option>
                                <option value="closed" <?php if ($row['status'] == 'closed') echo 'selected'; ?>>Closed</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </form>
                </div>
            </body>

            </html>

<?php
        } else {
            echo "Lead not found or not assigned to you";
        }
    }
} else {
    header("Location: ../index.php");
    mysqli_close($conn);
}
?>