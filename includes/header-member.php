<?php
	require_once 'includes/sessions.php';
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Book Inventory Pages</title>
    <link href="css/styles.css" rel="stylesheet">
  </head>
  <body>
    <div class="page">
      <header>
        <div class="header-left">
          <div class="logo">
            <img src="imgs/book-logo.jpg" alt="Book Inventory Logo">
              </div>
              <nav>
                <ul>
                  <li><a href="book-cat.php">Book Catalog</a></li>
                  <li><a href="about.php">About</a></li>
                  <?= $logged_in ? '<a href="logout.php">Log Out</a>' : '<a href="login.php">Log In</a>'; ?>
                </ul>
            </nav>
          </div>

          <div class="header-right">
            <ul>
          <li><a href="groups.php">Groups</a></li>
              <li><a href="list.php">Lists</a></li>
            </ul>
          </div>
      </header>
      <section>