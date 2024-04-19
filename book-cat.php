<?php   										// Opening PHP tag
	
	// Include the database connection script
	require 'includes/database-connection.php';


	function search_books(PDO $pdo, string $title) {

		// SQL query to retrieve book information based on the book ID
		$sql = "SELECT * 
			FROM books
			WHERE title= :title;";	// :id is a placeholder for value provided later 
		                               // It's a parameterized query that helps prevent SQL injection attacks and ensures safer interaction with the database.


		// Execute the SQL query using the pdo function and fetch the result
		$book = pdo($pdo, $sql, ['title' => "%$title%"])->fetchAll();		// Associative array where 'id' is the key and $id is the value. Used to bind the value of $id to the placeholder :id in  SQL query.

		// Return the book information 
		return $book;
	}

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		// Retrieve the value of the 'listName' field from the POST data
		$title = $_POST['title'];

		$allBooks= search_books($pdo, $title);


	} else {
        // If the form is not submitted, fetch all books
        $allBooks = search_books($pdo, ''); 
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
  			<section class="book-catalog">

  				    <?php
                    // Check if there are any search results
                    if (!empty($allBooks)) {
                        // Iterate over each book in the search results
                        foreach ($allBooks as $book) {
                            <div class="book-card">
                              <a href="book.php?bookID=<?= $book['bookID'] ?>">
                              <h2><?= $book['title'] ?></h2>
                              <p><?= $book['authors'] ?></p>
                              </a>
                            </div>;
                        }
                    } else {
                        <p>No matching books found.</p>
                    }
                ?>

   			</section>
  		</main>

	</body>
</html>



