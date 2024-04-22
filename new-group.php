<?php   										// Opening PHP tag
	
	// Include the database connection script
	require 'includes/database-connection.php';


	function add_new_group(PDO $pdo, string $userId, string $groupName){
		// start transaction
    $pdo->beginTransaction();
    // create new group
    $sql = "INSERT INTO groups (group_name) VALUES (:groupName);";
		$stmt = pdo($pdo, $sql, ['groupName' => $groupName])->prepare();		

    // get new groupID
    $newGroupId = $pdo->lastInsertId();

    // add user to group
    $userGroupSql = "INSERT INTO user_groups (groupID, userID) VALUES (:groupID, :userId);";
    $stmt = pdo($pdo, $userGroupSql, ['groupID' => $newGroupId, 'userId' => $userId]);

    // Commit transaction
    $pdo->commit();
	}

$created = False;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submitNewGroup'])) {
        $newGroupName = $_POST['newGroupName'];
        // create new group
        // **** CHANGE '1' with the actual userID when login implement 
        add_new_group($pdo, '1', $newGroupName); 
        $created = True;
    } 
    
}
	
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
					<form action="new-group.php" method="POST">
              <div class="form-group">
                  <label for="newGroupName">New Group Name:</label>
                  <input type="text" id="newGroupName" name="newGroupName" required>
              </div>

              <button type="submit" name="submitNewGroup">Add New Group</button>
          </form>
				</div>	
        
				<?php if($created): ?>
            <p>Group "<?php echo $newGroupName; ?>" has been created.</p>
        <?php endif; ?>

			</div>

		</main>

	</body>

</html>
