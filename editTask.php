<?php
session_start();
include 'connection.inc.php';
include 'top.inc.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$message = "";

if (isset($_GET['id'])) {
    $task_id = intval($_GET['id']);

    $sql = "SELECT * FROM tasks WHERE id = ? AND userID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $task_id, $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $task = $result->fetch_assoc();
    $stmt->close();

    if (!$task) {
        echo "Task not found.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task_title = trim($_POST['task_title']);
    $task_description = trim($_POST['task_description']);
    $due_date = $_POST['due_date'];

    if (empty($task_title)) {
        $message = "Task title is required.";
    } else {
        $sql = "UPDATE tasks SET title = ?, description = ?, dueDate = ? WHERE id = ? AND userID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssii", $task_title, $task_description, $due_date, $task_id, $_SESSION['user_id']);

        if ($stmt->execute()) {

            header('Location: index.php');
            exit();
        } else {
            $message = "Error: Could not update task.";
        }
        $stmt->close();
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
        <h1 class="title has-text-centered has-text-white">Edit Task</h1><hr>
        <div class="box">
            
            <?php if (!empty($message)): ?>
                <div class="notification is-danger">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="editTask.php?id=<?php echo $task_id; ?>">
                <div class="field">
                    <label class="label">Task Title</label>
                    <div class="control">
                        <input class="input" type="text" name="task_title" 
                               value="<?php echo htmlspecialchars($task['title']); ?>" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Task Description</label>
                    <div class="control">
                        <textarea class="textarea" name="task_description"><?php echo htmlspecialchars($task['description']); ?></textarea>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Due Date</label>
                    <div class="control">
                        <input class="input" type="date" name="due_date" 
                               value="<?php echo htmlspecialchars($task['dueDate']); ?>">
                    </div>
                </div>

                <div class="field">
                    <div class="control has-text-centered">
                        <button class="button is-black" type="submit">Update Task</button>
                        <a class="button is-light" href="index.php">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
</body>
</html>
