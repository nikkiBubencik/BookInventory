<?php   										// Opening PHP tag
	
	// Include the database connection script
	require 'includes/database-connection.php';


	function find_groups_by_name(PDO $pdo, string $groupName){
		$sql = "SELECT *
				FROM groups as g join user_groups as ug on g.groupID = ug.groupID
				WHERE group_name LIKE :groupName;";
		
		$group = pdo($pdo, $sql, ['groupName' => "%$groupName%"])->fetchAll();		
		return $group;
	}

	
	// Check if the request method is POST (i.e, form submitted)
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		// Retrieve the value of the 'listName' field from the POST data
		$groupName = $_POST['groupName'];

		$groups= find_groups_by_name($pdo, $groupName);

		// Check if the list exists
		if ($groups) {
			// If the list exists, redirect to group.php with groupID parameter
			header("Location: groups.php?groupID=" . $groups['groupID']);
			exit(); 
		}
	}

	function get_all_users_groups(PDO $pdo, $userId) {
	    	$sql = "SELECT * FROM groups as g 
            JOIN user_groups as ug ON g.groupID = ug.groupID
            WHERE userID = :userId";
		$groups = pdo($pdo, $sql, ['userId' => $userId])->fetchAll();		

	    	return $groups;
	}
	// CHNAGE '1' to $userId so its for the user who is logged in
	$allGroups = ($_SERVER["REQUEST_METHOD"] == "POST") ? $groups : get_all_users_groups($pdo, '1');
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
            			<li><a href="groups.php">Groups</a></li>  
		    		<li><a href="list.php">Lists</a></li>
		    	</ul>
		    </div>
		</header>

		<main>

			<div class="group-lookup-container">
				<div class="group-lookup-container">
					<h1>Group Lookup</h1>
					<form action="groups.php" method="POST">
						<div class="form-group">
							<label for="groupName">Group Name:</label>
						        <input type="text" id="groupName" name="groupName" required>
						</div>

						<button type="submit">Lookup Group</button>
					</form>
				</div>
				
				<div class="group-names">
				    	<h2>Your Groups</h2>
				    	<ul>
				        <?php foreach ($allGroups as $group): ?>
						<li><a href="groupLists.php?listID=<?= $group['groupID'] ?>&group_name=<?= $group['group_name'] ?>">
						        <?= $group['group_name'] ?></a></li>
				        <?php endforeach; ?>
				    	</ul>
				</div>
				
				

			</div>

		</main>

	</body>

</html>
