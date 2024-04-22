<?php   										// Opening PHP tag
	
	// Include the database connection script
	require 'includes/database-connection.php';

  	$bookId = $_GET['bookId'];
  	$bookName = $_GET['bookName'];
	$listName = '';
	$created = False;

	function add_book_to_list(PDO $pdo, string $bookId, string $listName, $listNotFound){
	    // start transaction
	    $pdo->beginTransaction();
	    
	    // Query to get listID from listName
	    $listIdQuery = "SELECT listID FROM reading_list WHERE list_name = :listName;";
	    $listIdResult = pdo($pdo, $listIdQuery, ['listName' => $listName])->fetch();		
	
	    if (!$listIdResult) {
	        $listNotFound = True;
	        $pdo->rollBack();
	        return;
	    }
	
	    // insert book into list
	    $listId = $listIdResult['listID'];
			$sql = "INSERT INTO user_books (listID, bookID, date_added) VALUES (:listId, :bookId, DATE())";
			$stmt = pdo($pdo, $sql, ['listId' => $listId, 'bookId' => $bookId]);
	
	    // Commit transaction
	    $pdo->commit();
	    return $listNotFound;
	}

	$listNotFound = True;
	
	// Check if the request method is POST (i.e, form submitted)
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		// Retrieve the value of the 'bookName' field from the POST data
		$listName = $_POST['listName'];
		$allBooks = add_book_to_list($pdo, $bookId, $listName, $listNotFound);
		$created = True;
		if(!$allBooks){
			$listNotFound = False;
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

			<div class="add-book-list-container">
				<div class="add-book-list-container">
					<h1>Add Book to List</h1>
					<form action="add-book.php?bookId=<?= $bookId ?>&bookName=<?= $bookName ?>" method="POST">
						<div class="form-group">
							<label for="listName">List Name: </label>
						        <input type="text" id="listName" name="listName" required>
						</div>

						<button type="submit">Add Book to List</button>

					</form>
				</div>
            				<?php if($created): ?>
		            			<p><?= $bookName ?> has been added to <?= $listName ?> List </p>
		        		<?php endif; ?>	
					<?php if($listNotFound): ?>
						<P> <?= $listName ?> not found</P>
					<?php endif; ?>

			</div>

		</main>

	</body>

</html>
