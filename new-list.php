<?php   										// Opening PHP tag
	
	// Include the database connection script
	require 'includes/database-connection.php';


	function add_new_list(PDO $pdo, string $userId, string $listName, string $desc){
		// start transaction
    $pdo->beginTransaction();
    // create new group
    $sql = "INSERT INTO reading_list (list_name, userID, description, date_added) VALUES (:listName, :userId, :desc, CURDATE());";
    $stmt = pdo($pdo, $sql, ['listName' => $listName, 'userId' => $userId, 'desc' => $desc]);		

    // Commit transaction
    $pdo->commit();
	}

$created = False;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submitNewList'])) {
        $newListName = $_POST['newListName'];
        $desc = $_POST['listDesc'];
        // **** CHANGE '1' with the actual userID when login implement 
        add_new_list($pdo, '1', $newListName, $desc); 
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

			<div class="list-create-container">
				<div class="list-create-container">
					<h1>Create List</h1>
					<form action="new-list.php" method="POST">
              <div class="form-group">
                  <label for="newListName">New List Name:</label>
                  <input type="text" id="newListName" name="newListName" required>
              </div>
              <div class="form-group">
                  <label for="listDesc">Description:</label>
                  <input type="text" id="listDesc" name="listDesc" required>
              </div>
              <button type="submit" name="submitNewList">Add New List</button>
          </form>
				</div>	
        
				<?php if($created): ?>
            <p>List "<?php echo $newListName; ?>" has been created.</p>
        <?php endif; ?>

			</div>

		</main>

	</body>

</html>
