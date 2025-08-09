<?php
include('../db.php');         // Connect to DB
session_start();              // Start session

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Step 1: Get email and password
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Step 2: Validate input
    if (empty($email) || empty($password)) {
        $error = "Both fields are required.";
    } else {
        // Step 3: Fetch user by email
        $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);

            // Step 4: Verify password
            if (password_verify($password, $user['password'])) {
                // Step 5: Store user in session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                // Step 6: Redirect to dashboard
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "No account found with that email.";
        }
    }
}
?>

<!-- Step 7: HTML Login Form -->
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="../assets/bootstrap/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>Login</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" required />
        </div>

        <div class="mb-3">
            <label>Password:</label>
            <input type="password" name="password" class="form-control" required />
        </div>

        <button type="submit" class="btn btn-success">Login</button>
    </form>
</body>
</html>
