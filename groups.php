<?php   										// Opening PHP tag
	
	// Include the database connection script
	require 'includes/database-connection.php';


	function search_groups_by_name(PDO $pdo, string $groupName, string $userId){
		$sql = "SELECT *
			FROM groups as g join user_groups as ug on g.groupID = ug.groupID
			WHERE group_name LIKE :groupName and userID = :userId;";
		
		$group = pdo($pdo, $sql, ['groupName' => "%$groupName%", 'userId' => $userId])->fetchAll();		
		return $group;
	}

	
	// Check if the request method is POST (i.e, form submitted)
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		// Retrieve the value of the 'bookName' field from the POST data
		$groupName = $_POST['groupName'];
	}
	else{
		$groupName = '';
	}
	// ***CHANGE FROM '1' TO USERID WHEN WE GET A LOGIN***
	$allGroups = search_groups_by_name($pdo, $groupName, '1');
	
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

			<div class="group-lookup-container">
				<div class="group-lookup-container">
					<h1>Group Lookup</h1>
					<form action="groups.php" method="POST">
						<div class="form-group">
							<label for="groupName">Group Name: </label>
						        <input type="text" id="groupName" name="groupName" required>
						</div>

						<button type="submit">Lookup Group</button>
					</form>
				</div>
				
				<div class="Group-names">
					<h2>Your Groups</h2>
					<ul style="list-style-type: none; padding: 0;">
				        <?php foreach ($allGroups as $group): ?>
						<li><a href="groupLists.php?groupID=<?= $group['groupID'] ?>&groupName=<?= $group['group_name'] ?>">
						<?= $group['group_name'] ?></a>
						</li>
			
					<hr>
				        <?php endforeach; ?>
				    	</ul>
				</div>
				
				

			</div>

		</main>

	</body>

</html>
