<?php   										// Opening PHP tag
	
	// Include the database connection script
	require 'includes/database-connection.php';

  $groupID = $_GET['groupID'];
  $groupName = $_GET['group_name'];

	function find_lists_by_name(PDO $pdo, string $listName){
		$sql = "SELECT *
				FROM reading_list  as r
        JOIN group_lists as g on r.listID = g.listID
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
		if ($lists) {
			// If the list exists, redirect to list.php with listID parameter
			header("Location: groupLists.php?listID=" . $list['listID']);
			exit(); 
		}
	}

	function get_all_user_lists(PDO $pdo, $userId) {
	    	$sql = "SELECT * FROM reading_list as r 
        JOIN group_lists as g ON r.listID = g.listID
        WHERE userID = :userId";
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
	      				<li><a href="book-cat.php">Book Catalog</a></li>
	      				<li><a href="about.php">About</a></li>
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

		<main>

			<div class="list-lookup-container">
				<div class="list-lookup-container">
					<h1>Group List Lookup</h1>
					<form action="groupLists.php" method="POST">
						<div class="form-group">
							<label for="listName">Group List Name:</label>
						        <input type="text" id="listName" name="listName" required>
						</div>

						<button type="submit">Lookup Group List</button>
					</form>
				</div>
				
				<div class="list-names">
				    	<h2><?= $groupName ?>'s Lists</h2>
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
