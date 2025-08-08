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
  <nav class="navbar is-info" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
      <a class="navbar-item">
        <strong class="title is-4 has-text-weight-bold">To Do App</strong>
      </a>

      <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarMenu">
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
      </a>
    </div>

    <div id="navbarMenu" class="navbar-menu">
      <div class="navbar-start">
      <a href="index.php" class="navbar-item">All Task</a>
        <a href="addTask.php" class="navbar-item">Add Task</a>

        <div class="navbar-item has-dropdown is-hoverable">
          <a class="navbar-link">Categories</a>
          <div class="navbar-dropdown">
            <a class="navbar-item">Personal</a>
            <a class="navbar-item">Work</a>
            <a class="navbar-item">Shopping</a>
            <hr class="navbar-divider">
            <a href="log_out.php" class="navbar-item">log out</a>
          </div>
        </div>
      </div>
    </div>
  </nav>
  
