<?php   										// Opening PHP tag
	
	// Include the database connection script
	require 'includes/database-connection.php';
	include 'includes/header-member.php';

	function find_lists_by_name(PDO $pdo, string $listName, string $userId){
		$sql = "SELECT *
				FROM reading_list
				WHERE list_name LIKE :listName 
    				AND userID = :userId;";
		
		$list = pdo($pdo, $sql, ['listName' => "%$listName%", 'userId' => $userId])->fetchAll();		
		return $list;
	}

	
	// Check if the request method is POST (i.e, form submitted)
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		// Retrieve the value of the 'listName' field from the POST data
		$listName = $_POST['listName'];

		// ***CHANGE FROM '1' TO USERID WHEN WE GET A LOGIN***
		$lists = find_lists_by_name($pdo, $listName, '1');

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

		<main>

			<div class="list-lookup-container">
				<div class="list-lookup-container">
					<h1>List Lookup</h1>
					<form action="list.php" method="POST">
						<div class="form-group">
							<label for="listName">List Name: </label>
						        <input type="text" id="listName" name="listName" required>
						</div>

						<button type="submit">Lookup List</button>
						<button onclick="location.href='new-list.php'; return false;" type="button">Add New List</button>

					</form>
				</div>
				
				<div class="list-names">
				    	<h2>Your Lists</h2>
				    	<ul>
				        <?php foreach ($allLists as $list): ?>
						<li><a href="list_books.php?listID=<?= $list['listID'] ?>&listName=<?= $list['list_name'] ?>">
						<?= $list['list_name'] ?></a></li>
				        <?php endforeach; ?>
				    	</ul>
				</div>
				
				

			</div>

		</main>

	</body>

</html>
