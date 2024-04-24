<?php include 'includes/header-member.php'; ?>

<?php
    if ($logged_in) {                              // If already logged in
        header('Location: list.php');              // Redirect to list page
        exit;                                      // Stop further code running
    }    

    if($_SERVER['REQUEST_METHOD'] == 'POST') {     // If form submitted
        $user_email    = $_POST['email'];          // Email user sent
        $user_password = $_POST['password'];       // Password user sent

        if (login($user_email, $user_password)) {
            header('Location: list.php');
            exit;
        } else {
            echo "Invalid email or password. Please try again.";
        }
    }
?>


<!DOCTYPE>
<html>
	<head>
		<meta charset="UTF-8">
  		<meta name="viewport" content="width=device-width, initial-scale=1.0">
  		<title>Book Inventory</title>
  		<link rel="stylesheet" href="css/style.css">
  		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Lilita+One&display=swap" rel="stylesheet">
	</head>
    <body>
        <main>

        <h1>Login</h1>

        <form method="POST" action="login.php">
            Email:      <input type="email" name="email"><br>
            Password:   <input type="password" name="password"><br>
            <input type="submit" value="Log In">
        </form>

        </body>
    </main>
</html>



<?php include 'includes/footer.php'; ?>