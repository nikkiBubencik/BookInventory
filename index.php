<?php   										// Opening PHP tag
	
	// Include the database connection script
	require 'includes/database-connection.php';

	/*
	 * Retrieve toy information from the database based on the toy ID.
	 * 
	 * @param PDO $pdo       An instance of the PDO class.
	 * @param string $id     The ID of the toy to retrieve.
	 * @return array|null    An associative array containing the toy information, or null if no toy is found.
	 */
	function get_book(PDO $pdo, string $id) {

		// SQL query to retrieve book information based on the book ID
		$sql = "SELECT * 
			FROM books
			WHERE bookID= :id;";	// :id is a placeholder for value provided later 
		                               // It's a parameterized query that helps prevent SQL injection attacks and ensures safer interaction with the database.


		// Execute the SQL query using the pdo function and fetch the result
		$book = pdo($pdo, $sql, ['id' => $id])->fetch();		// Associative array where 'id' is the key and $id is the value. Used to bind the value of $id to the placeholder :id in  SQL query.

		// Return the toy information (associative array)
		return $book;
	}

	// Retrieve info about toy with ID '0001' from the db using provided PDO connection
	$book1 = get_book($pdo, '2');
	// $toy2 = get_toy($pdo, '0002');
	// $toy3 = get_toy($pdo, '0003');
	// $toy4 = get_toy($pdo, '0004');
	// $toy5 = get_toy($pdo, '0005');
	// $toy6 = get_toy($pdo, '0006');
	// $toy7 = get_toy($pdo, '0007');
	// $toy8 = get_toy($pdo, '0008');
	// $toy9 = get_toy($pdo, '0009');
	// $toy10 = get_toy($pdo, '0010');
	/*
	 * TO-DO: Retrieve info for ALL remaining toys from the db
	 */


// Closing PHP tag  ?> 

<!DOCTYPE>
<html>

	<head>
		<meta charset="UTF-8">
  		<meta name="viewport" content="width=device-width, initial-scale=1.0">
  		<title>Toys R URI</title>
  		<link rel="stylesheet" href="css/style.css">
  		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Lilita+One&display=swap" rel="stylesheet">
	</head>

	<body>

		<header>
			<div class="header-left">
				<div class="logo">
					<img src="imgs/logo.png" alt="Toy R URI Logo">
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
		    		<li><a href="order.php">Check Order</a></li>
		    	</ul>
		    </div>
		</header>

  		<main>
  			<section class="toy-catalog">

  				<div class="toy-card">
  					<!-- Create a hyperlink to toy.php page with toy number as parameter -->

  					<!-- Displaytitle of book -->
					<a href="toy.php?bookID=<?= $book1['bookID'] ?>">
  						<h2><?= $book1['title'] ?></h2>

  					<!-- Display authors -->
  					<p><?= $book1['authors'] ?></p>
					</a>
  				</div>

   			</section>
  		</main>

	</body>
</html>



