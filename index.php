<?php
include('seeding.php');
session_start();
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css" />
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Login</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="login.php" method="POST">
                    <div class="alert alert-primary" role="alert">
                        <div>
                            <p>
                                <strong>Admin sign-in= </strong>username :<strong>admin,</strong> pass:<strong>admin123</strong> , user type:admin
                            </p>
                        </div>
                        <div>
                            <p>
                                <strong>Employee sign-in= </strong>username : <strong>employee1</strong>, pass:<strong>employee1123</strong>,usertype:employee
                            </p>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" id="username" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="user_type" class="form-label">User Type:</label>
                        <select id="user_type" name="user_type" class="form-select" required>
                            <option value="admin">Admin</option>
                            <option value="employee">Employee</option>
                        </select>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>