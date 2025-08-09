<?php
include('../db.php');

$success = "";
$error = "";    

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = $_POST['password'];
    
    if (empty($username) || empty($email) || empty($password)) {
        $error = "All Fields are required.";
    } elseif (strlen($password) < 8 ) {
        $error = "Password Must Be At Least Of 8 Characters.";
    } else {
        $email = mysqli_real_escape_string($conn, $email);
        $check = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
        if (mysqli_num_rows($check) > 0) {
            $error = "Email already Registered.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = mysqli_prepare($conn, "INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashed_password);

            if (mysqli_stmt_execute($stmt)) {
                $success = "Registration successful! <a href='login.php'>Login here</a>";
            } else {
                $error = "Registration failed. Try again.";
            }
        }
    }
}


?>



<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="../assets/bootstrap/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>Register</h2>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php elseif ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label>Username:</label>
            <input type="text" name="username" class="form-control" required />
        </div>

        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" required />
        </div>

        <div class="mb-3">
            <label>Password:</label>
            <input type="password" name="password" class="form-control" required />
        </div>

        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</body>
</html>