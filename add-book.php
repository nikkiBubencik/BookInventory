<?php   										// Opening PHP tag
	
	// Include the database connection script
	require 'includes/database-connection.php';
	include 'includes/header-member.php';

  	$bookId = $_GET['bookId'];
	$bookName = get_book_title($pdo, $bookId);
  	// $bookName = $_GET['bookName'];
	$listName = '';

	function get_book_title(PDO $pdo, string $bookId){
		$sql = "SELECT title FROM books WHERE bookID = :bookId";
		$bookTitle = pdo($pdo, $sql, ['bookId' => $bookId])->fetch();
		return $bookTitle['title'];
	}
	
	function add_book_to_list(PDO $pdo, string $bookId, int $listId, $listNotFound){
		// start transaction
		$pdo->beginTransaction();
		
		// Check if the book already exists in the list
		$bookExistsQuery = "SELECT COUNT(*) AS count FROM user_books WHERE listID = :listId AND bookID = :bookId";
		$bookExistsResult = pdo($pdo, $bookExistsQuery, ['listId' => $listId, 'bookId' => $bookId])->fetch();
	
		if ($bookExistsResult['count'] > 0) {
			$listNotFound = 2; 
			$pdo->rollBack();
			return $listNotFound;
		}
		
		// insert book into list
		$sql = "INSERT INTO user_books (listID, bookID, date_added) VALUES (:listId, :bookId, CURDATE())";
		$stmt = pdo($pdo, $sql, ['listId' => $listId, 'bookId' => $bookId]);
	
		// Commit transaction
		$pdo->commit();
		return $listNotFound;
	}
	
	$listNotFound = 0;
	
	// Check if the request method is POST (i.e, form submitted)
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		// Retrieve the value of the 'bookName' field from the POST data
		// $listName = $_POST['listName'];
		// $listNotFound = add_book_to_list($pdo, $bookId, $listName, $listNotFound);
		$selectedLists = $_POST['lists'];

		// Loop through each selected list
		foreach ($selectedLists as $selectedListId) {
			// Add the book to the selected list
			$listNotFound = add_book_to_list($pdo, $bookId, $selectedListId, $listNotFound);
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
		<main>

			<div class="add-book-list-container">
				<div class="add-book-list-container">
					<h1>Add <?= $bookName ?> to your Lists</h1>
					<form action="add-book.php?bookId=<?= $bookId ?>" method="POST">
						<div class="form-group">
							<label for="listName">Select Lists: </label>
							<?php
							// Assuming $pdo is your database connection
							// Retrieve userID from the session
							$userID = $_SESSION['userID'];

							// Query to fetch lists belonging to the current user
							$sql = "SELECT * FROM reading_list WHERE userID = ?";
							$statement = $pdo->prepare($sql);
							$statement->execute([$userID]);
							$userLists = $statement->fetchAll(PDO::FETCH_ASSOC);

							// Iterate through the user's lists
							foreach ($userLists as $list) {
								echo '<div><input type="checkbox" id="' . $list['listID'] . '" name="lists[]" value="' . $list['listID'] . '"><label for="' . $list['listID'] . '">' . $list['list_name'] . '</label></div>';
							}
							?>
						</div>

						<button type="submit">Add Book to List</button>
						<a href="javascript:window.history.back();" class="back-button">Back</a>

					</form>
				</div>
            				<?php if(isset($_POST['lists'])): ?>
						<?php if($listNotFound == 1): ?>
							<P> <?= $listName ?> not found</P>
						<?php elseif($listNotFound == 0): ?>
			            			<p><?= $bookName ?> has been added to the selected lists<?= $listName ?> List </p>
						<?php elseif($listNotFound == 2): ?>
			            			<p><?= $bookName ?> is already in one or more of the selected lists </p>
						<?php endif; ?>
					<?php endif; ?>
			</div>

		</main>

	</body>

</html>