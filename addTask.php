<?php
session_start();
include 'connection.inc.php';
require('top.inc.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$message = "";
$is_error = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $task_title = trim($_POST['task_title']);
    $task_description = trim($_POST['task_description']);
    $due_date = $_POST['due_date'];
    $user_id = $_SESSION['user_id'];


    if (empty($task_title)) {
        $message = "Task title is required.";
        $is_error = true;
    } else {
        
        $sql = "INSERT INTO tasks (userID, title, description, dueDate) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("isss", $user_id, $task_title, $task_description, $due_date);
            if ($stmt->execute()) {
                $message = "Task added successfully.";
            } else {
                $message = "Error: Could not add task. Please try again.";
                $is_error = true;
            }
            $stmt->close();
        } else {
            $message = "Error: Failed to prepare the SQL statement.";
            $is_error = true;
        }
    }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TO DO LIST</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  </head>
  <body>
<section class="section">
    <div class="container py-5">
        <h1 class="title has-text-centered">Add Tasks</h1>
        <p class="subtitle has-text-centered">Add Your Important Task & Be Updated..!</p><hr>
        <div class="box has-shadow">
            
            <?php if (!empty($message)) : ?>
                <div class="notification <?= $is_error ? 'is-danger' : 'is-success'; ?>">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>

            <!-- Task form -->
            <form method="POST" action="addTask.php">

                <div class="field">
                    <label class="label">Task Title</label>
                    <div class="control">
                        <input class="input" type="text" name="task_title" placeholder="Enter task title" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Task Description</label>
                    <div class="control">
                        <textarea class="textarea" name="task_description" placeholder="Enter task description"></textarea>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Due Date</label>
                    <div class="control">
                        <input class="input" type="date" name="due_date">
                    </div>
                </div>

                <div class="field">
                    <div class="control has-text-centered">
                        <button class="button is-black" type="submit">Add Task</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<script src="JS/main.js"></script>
</body>
</html>
