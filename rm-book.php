<?php   										// Opening PHP tag
	
	// Include the database connection script
	require 'includes/database-connection.php';

  	$bookId = $_GET['bookId'];
  	$bookName = $_GET['bookName'];
	$listName = '';

	function remove_book_from_list(PDO $pdo, string $bookId, string $listName, &$listNotFound){
	    // start transaction
	    $pdo->beginTransaction();
	    
	    // Query to get listID from listName
	    $listIdQuery = "SELECT listID FROM reading_list WHERE list_name = :listName;";
	    $listIdResult = pdo($pdo, $listIdQuery, ['listName' => $listName])->fetch();		
		
	    if (!$listIdResult) {
	        $listNotFound = 1;
	        $pdo->rollBack();
	        return ;
	    }

	   // Check if the book already exists in the list
	    $listId = $listIdResult['listID'];
	    $bookExistsQuery = "SELECT COUNT(*) AS count FROM user_books WHERE listID = :listId AND bookID = :bookId";
	    $bookExistsResult = pdo($pdo, $bookExistsQuery, ['listId' => $listId, 'bookId' => $bookId])->fetch();
	
	    if ($bookExistsResult['count'] > 0) {
	        $listNotFound = 2; 
	        $pdo->rollBack();
	        return;
	    }
		
	    // insert book into list
	    $sql = "DELETE FROM user_books WHERE listID = :listId and bookID = :bookId";
	    $stmt = pdo($pdo, $sql, ['listId' => $listId, 'bookId' => $bookId]);
	
	    // Commit transaction
	    $pdo->commit();
	    return ;
	}

	$listNotFound = 0;
	
	// Check if the request method is POST (i.e, form submitted)
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		// Retrieve the value of the 'bookName' field from the POST data
		$listName = $_POST['listName'];
		$listNotFound = remove_book_from_list($pdo, $bookId, $listName, $listNotFound);
		
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

			<div class="rm-book-list-container">
				<div class="rm-book-list-container">
					<h1>Remove Book from List</h1>
					<form action="rm-book.php?bookId=<?= $bookId ?>&bookName=<?= $bookName ?>" method="POST">
						<div class="form-group">
							<label for="listName">List Name: </label>
						        <input type="text" id="listName" name="listName" required>
						</div>

						<button type="submit">Remove Book from List</button>

					</form>
				</div>
            				<?php if(isset($_POST['listName'])): ?>
						<?php if($listNotFound == 1): ?>
							<P> <?= $listName ?> not found</P>
						<?php elseif($listNotFound == 0): ?>
			            			<p><?= $bookName ?> has been removed from <?= $listName ?> List </p>
						<?php elseif($listNotFound == 2): ?>
			            			<p><?= $bookName ?> is not in <?= $listName ?> List </p>
						<?php endif; ?>
					<?php endif; ?>
			</div>

		</main>

	</body>

</html>
