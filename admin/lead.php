<?php
session_start();
include('../database.php');

if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'admin') {
    function sanitize($field)
    {
        $field = htmlspecialchars($field);
        $field = trim($field);
        $field = stripslashes($field);
        return $field;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Handle form submission
        $name = sanitize($_POST['name']);
        $email = sanitize($_POST['email']);
        $phone = sanitize($_POST['phone']);
        $status = sanitize($_POST['status']);
        $assigned_to = sanitize($_POST['assigned_to']);

        $sql = "INSERT INTO leads (name, email, phone, status, assigned_to) VALUES ('$name', '$email', '$phone', '$status', '$assigned_to')";

        if (mysqli_query($conn, $sql)) {
            header('Location:admin_dashboard.php');
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add Lead</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css" />
    </head>

    <body>
        <div class="container">
            <h1 class="mt-5">Add Lead</h1>
            <a href="admin_dashboard.php" class="btn btn-primary mt-3">Back to Dashboard</a><br><br>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="mb-3">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone:</label>
                    <input type="text" id="phone" name="phone" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status:</label>
                    <select id="status" name="status" class="form-select">
                        <option value="new">New</option>
                        <option value="contacted">Contacted</option>
                        <option value="follow-up">Follow-up</option>
                        <option value="converted">Converted</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="assigned_to" class="form-label">Assigned To:</label>
                    <select id="assigned_to" name="assigned_to" class="form-select">
                        <!-- Assuming you have employees listed in the users table -->
                        <?php
                        $employee_query = "SELECT * FROM users WHERE user_type = 'employee'";
                        $employee_result = mysqli_query($conn, $employee_query);
                        if ($employee_result->num_rows > 0) {
                            while ($row = mysqli_fetch_assoc($employee_result)) {
                                echo "<option value='" . $row['id'] . "'>" . $row['username'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Add Lead</button>
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