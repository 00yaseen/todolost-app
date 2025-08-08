<?php
require('connection.inc.php');
require('top.inc.php');

$sql = "SELECT * FROM tasks";
$result = $conn->query($sql);
?>
<section class="section">
    <div class="container py-5">
      <h1 class="title has-text-centered">
        All Task
      </h1>
      <p class="subtitle has-text-centered">
        All Task is Here
    </p><hr>
      <!--card-->
      <?php
    if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) { 
      ?>

<div class="card">
    <div class="card-content">
        <p class="title is-5 has-text-weight-bold">
            <label class="checkbox">
                <input type="checkbox" class="delete-checkbox" style="transform: scale(1.5);">&nbsp;
                <?php echo htmlspecialchars($row['title']); ?>
            </label>
        </p>
        <?php echo htmlspecialchars($row['description']); ?> <time>____Date: <?php echo htmlspecialchars($row['dueDate']); ?></time>
        <div class="buttons is-right">
        <a href="editTask.php?id=<?php echo $row['id']; ?>">
            <button class="button is-success">
                <span class="icon">
                    <i class="fas fa-edit fa-lg"></i>
                </span>
            </button>
    </a>
            <button class="button is-danger manual-delete">
                <span class="icon">
                    <i class="fas fa-trash fa-lg"></i>
                </span>
            </button>
        </div>
    </div>
</div>

      <?php
    }
} else {
    $msg = "No tasks found.";
}
$conn->close();
?>
<!--card end-->
    <?php if (!empty($msg)): ?>
    <div class="notification"><?php echo htmlspecialchars($msg); ?></div>
    <?php endif; ?>
    <a href="addTask.php" class="button is-danger add-task-fab">
    <span class="icon">
        <i class="fas fa-plus"></i>
    </span>
</a>
    </div>
    </div>
  </section>
  <script src="JS/main.js"></script>
