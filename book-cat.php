<?php   										// Opening PHP tag
	
	// Include the database connection script
	require 'includes/database-connection.php';


	function search_books_by_name(PDO $pdo, string $bookName){
		$sql = "SELECT *
				FROM books
    				WHERE title LIKE :bookName
				OR authors LIKE :bookName
				LIMIT 25;";
		
		$books = pdo($pdo, $sql, ['bookName' => "%$bookName%"])->fetchAll();		
		return $books;
	}

	
	// Check if the request method is POST (i.e, form submitted)
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		// Retrieve the value of the 'bookName' field from the POST data
		$bookName = $_POST['bookName'];
	}
	else{
		$bookName = '';
	}
	// ***CHANGE FROM '1' TO USERID WHEN WE GET A LOGIN***
	$allBooks = search_books_by_name($pdo, $bookName);
	
	// // Check if the book exists
	// if ($list) {
	// 	// If the list exists, redirect to list.php with listID parameter
	// 	header("Location: list.php?listID=" . $list['listID']);
	// 	exit(); 
	// }
	

	// function get_all_user_lists(PDO $pdo, $userId) {
	//     	$sql = "SELECT * FROM reading_list WHERE userID = :userId";
	// 	$lists = pdo($pdo, $sql, ['userId' => $userId])->fetchAll();		

	//     	return $lists;
	// }
	// CHNAGE '1' to $userId so its for the user who is logged in
	// $allLists = ($_SERVER["REQUEST_METHOD"] == "POST") ? $lists : get_all_user_lists($pdo, '1');
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

			<div class="book-lookup-container">
				<div class="book-lookup-container">
					<h1>Book Lookup</h1>
					<form action="book-cat.php" method="POST">
						<div class="form-group">
							<label for="bookName">Book Name: </label>
						        <input type="text" id="bookName" name="bookName" required>
						</div>

						<button type="submit">Lookup Book</button>
					</form>
				</div>
				
				<div class="Books-names">
					<ul style="list-style-type: none; padding: 0;">
				        <?php foreach ($allBooks as $book): ?>
						<li><a href="book.php?bookID=<?= $book['bookID'] ?>">
						<?= $book['title'] ?></a></li>
						<?= $book['authors'] ?>
					<hr>
				        <?php endforeach; ?>
				    	</ul>
				</div>
				
				

			</div>

		</main>

	</body>

</html>
