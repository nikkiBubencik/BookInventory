<?php   										// Opening PHP tag
	
	// Include the database connection script
	require 'includes/database-connection.php';

	/*
	 * TO-DO: Define a function that retrives ALL customer and order info from the database based on values entered into form.
	 		  - Write SQL query to retrieve ALL customer and order info based on form values
	 		  - Execute the SQL query using the pdo function and fetch the result
	 		  - Return the order info
	 */

	function find_lists_by_name(PDO $pdo, string $listName){
		$sql = "SELECT *
				FROM reading_list
				WHERE list_name LIKE :listName;";
		
		$list = pdo($pdo, $sql, ['listName' => "%$listName%"])->fetchAll();		
		return $list;
	}

	
	// Check if the request method is POST (i.e, form submitted)
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		// Retrieve the value of the 'listName' field from the POST data
		$listName = $_POST['listName'];

		$lists = find_lists_by_name($pdo, $listName);

		// Check if the list exists
		if ($list) {
			// If the list exists, redirect to list.php with listID parameter
			header("Location: list.php?listID=" . $list['listID']);
			exit(); 
		}
	}

	function get_all_user_lists(PDO $pdo, $userId) {
	    	$sql = "SELECT * FROM reading_list WHERE userID = :userId";
		$lists = pdo($pdo, $sql, ['userId' => $userId])->fetchAll();		

	    	return $lists;
	}
	// CHNAGE '1' to $userId so its for the user who is logged in
	$allLists = ($_SERVER["REQUEST_METHOD"] == "POST") ? $lists : get_all_user_lists($pdo, '1');
// Closing PHP tag  ?> 

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

		<header>
			<div class="header-left">
				<div class="logo">
					<img src="imgs/book-logo.jpg" alt="Book Inventory Logo">
      			</div>

	      		<nav>
	      			<ul>
	      				<li><a href="index.php">Book Catalog</a></li>
	      				<li><a href="about.php">About</a></li>
			        </ul>
			    </nav>
		   	</div>

		    <div class="header-right">
		    	<ul>
		    		<li><a href="order.php">Lists</a></li>
		    	</ul>
		    </div>
		</header>

		<main>

			<div class="order-lookup-container">
				<div class="order-lookup-container">
					<h1>List Lookup</h1>
					<form action="order.php" method="POST">
						<div class="form-group">
							<label for="listName">List Name:</label>
						        <input type="text" id="listName" name="listName" required>
						</div>

						<button type="submit">Lookup List</button>
					</form>
				</div>
				
				<div class="list-names">
				    	<h2>Your Lists</h2>
				    	<ul>
				        <?php foreach ($allLists as $list): ?>
				            <li><a href="list.php?listID=<?= $list['listID'] ?>&title=<? $list['list_name'] ?>">
						<?= $list['list_name'] ?></a></li>
				        <?php endforeach; ?>
				    	</ul>
				</div>
				
				

			</div>

		</main>

	</body>

</html>
