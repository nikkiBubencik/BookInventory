<?php   										// Opening PHP tag
	
	// Include the database connection script
	require 'includes/database-connection.php';
	$listID = $_GET['listID'];
	$list_Name = $_GET['listName'];
	/*
	 * Retrieve toy information from the database based on the toy ID.
	 * 
	 * @param PDO $pdo       An instance of the PDO class.
	 * @param string $id     The ID of the toy to retrieve.
	 * @return array|null    An associative array containing the toy information, or null if no toy is found.
	 */
	function get_books(PDO $pdo, string $id) {

		// SQL query to retrieve books in a list
		$sql = "SELECT b.bookID, b.title, b.authors
			FROM books as b JOIN user_books as ub ON b.bookID = ub.bookID
			WHERE ub.listID= :id;";	// :id is a placeholder for value provided later 
		                               // It's a parameterized query that helps prevent SQL injection attacks and ensures safer interaction with the database.


		// Execute the SQL query using the pdo function and fetch the result
		$books = pdo($pdo, $sql, ['id' => $id])->fetchAll();		// Associative array where 'id' is the key and $id is the value. Used to bind the value of $id to the placeholder :id in  SQL query.

		// Return the book information (associative array)
		return $books;
	}

	$allBooks = get_books($pdo, $listID);

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
  			<section class="book-catalog">
				<h1>List Name: <?= $list_Name ?></h1>
				<br>
				<?php if (!empty($allBooks)) : ?>
					<?php foreach ($allBooks as $book): ?>
		  				<div class="book-card">
		  					<!-- Create a hyperlink to book.php page with book number as parameter -->
		
		  					<!-- Displaytitle of book -->
							<a href="book.php?bookID=<?= $book['bookID'] ?>">
		  						<h2><?= $book['title'] ?></h2>
		
		  					<!-- Display authors -->
		  					<p><?= $book['authors'] ?></p>
							</a>
							<button onclick="location.href='rm-book.php?bookId=<?= $book['bookId'] ?>&bookName=<?= $book['title'] ?>&listID=<?= $listID ?>&listName=<?= $list_Name ?>'; return false;" type="button">Remove Book From List</button>
							<hr>
		  				</div>
					<?php endforeach; ?>
				<?php else : ?>
		                	<p>No books found for this list.</p>
		            	<?php endif; ?>
   			</section>
  		</main>

	</body>
</html>
