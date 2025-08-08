<?php
include 'connection.inc.php';

$msg = ''; // Initialize message variable

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);

    if ($password === $confirmPassword) {
        // Check if username already exists
        $sql = "SELECT * FROM users WHERE name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $msg = "Username already exists.";
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Insert new user into the database
            $insertSql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
            $insertStmt = $conn->prepare($insertSql);
            $insertStmt->bind_param('sss', $username, $email, $hashedPassword);

            if ($insertStmt->execute()) {
                $msg = "Account created successfully.";
            } else {
                $msg = "Error creating account. Please try again later.";
            }
        }
    } else {
        $msg = "Passwords do not match.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>To-Do List - Sign Up</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
<link rel="stylesheet" href="CSS/style.css">
</head>
<body>
<section class="section is-flex is-align-items-center is-justify-content-center" style="height: 100vh;">
    <div class="container is-flex is-align-items-center is-justify-content-center">
        <div class="box is-outer-glow">
            <?php if (!empty($msg)): ?>
                <div class="notification is-info has-text-centered"> <?php echo $msg; ?> </div>
            <?php endif; ?>
            <h1 class="title has-text-centered">Sign Up</h1>
            <hr>
            <form method="post" class="form">
                <div class="field">
                    <label for="name" class="label">Username:</label>
                    <div class="control">
                        <input type="text" class="input" name="name" placeholder="Enter Username..." autocomplete="off" required>
                    </div>
                </div>

                <div class="field">
                    <label for="email" class="label">Email:</label>
                    <div class="control">
                        <input type="text" class="input" name="email" placeholder="Enter Email..." autocomplete="off" required>
                    </div>
                </div>

                <div class="field">
                    <label for="password" class="label">Password:</label>
                    <div class="control">
                        <input type="password" class="input" name="password" placeholder="Enter Password..." autocomplete="off" required>
                    </div>
                </div>
                <div class="field">
                    <label for="confirm_password" class="label">Confirm Password:</label>
                    <div class="control">
                        <input type="password" class="input" name="confirm_password" placeholder="Confirm Password..." autocomplete="off" required>
                    </div>
                </div>
                <div class="control has-text-centered">
                    <button class="button is-success" type="submit" name="submit">Sign Up</button>
                </div>
            </form>
            <hr>
            <p>Already have an account? <a href="log_in.php">Log In</a></p>
        </div>
    </div>
</section>
</body>
</html>
