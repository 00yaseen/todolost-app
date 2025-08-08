<?php
session_start();
include 'connection.inc.php';

$msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['name']);
    $password = trim($_POST['password']);


    $sql = "SELECT * FROM users WHERE name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {

            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['name'];
            header('Location: index.php');
            exit;
        } else {
            $msg = "Invalid password.";
        }
    } else {
        $msg = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>To-Do List - Log In</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
<link rel="stylesheet" href="CSS/style.css">
</head>
<body>
<section class="section is-flex is-align-items-center is-justify-content-center" style="height: 100vh;">
    <div class="container is-flex is-align-items-center is-justify-content-center">
        <div class="box is-outer-glow">
            <?php if (!empty($msg)): ?>
                <div class="notification is-danger has-text-centered"><?php echo htmlspecialchars($msg); ?></div>
            <?php endif; ?>
            <h1 class="title has-text-centered">Log In</h1>
            <hr>
            <form method="post" class="form">
                <div class="field">
                    <label for="name" class="label">Username:</label>
                    <div class="control">
                        <input type="text" class="input" name="name" placeholder="Enter Username..." autocomplete="off" required>
                    </div>
                </div>
                <div class="field">
                    <label for="password" class="label">Password:</label>
                    <div class="control">
                        <input type="password" class="input" name="password" placeholder="Enter Password..." autocomplete="off" required>
                    </div>
                </div>
                <div class="control has-text-centered">
                    <button class="button is-success" type="submit" name="submit">Log In</button>
                </div>
                <br>
                <a href="forgot.php">Forgot password?</a>
            </form>
            <hr>
            <p>Don't have an account? <a href="sign_up.php">Sign Up</a></p>
        </div>
    </div>
</section>
</body>
</html>
