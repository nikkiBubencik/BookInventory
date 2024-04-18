<?php   										// Opening PHP tag
	
	// Include the database connection script
	require 'includes/database-connection.php';

	// Retrieve the value of the 'toynum' parameter from the URL query string
	//		i.e., ../toy.php?toynum=0001
	$book_id = $_GET['bookID'];


	/*
	 * TO-DO: Define a function that retrieves ALL toy and manufacturer info from the database based on the toynum parameter from the URL query string.
	 		  - Write SQL query to retrieve ALL toy and manufacturer info based on toynum
	 		  - Execute the SQL query using the pdo function and fetch the result
	 		  - Return the toy info

	 		  Retrieve info about toy from the db using provided PDO connection
	 */
	function book_info(PDO $pdo, string $id){
		$sql = " SELECT *
				FROM books
				WHERE bookID= :id;";

		$info = pdo($pdo, $sql, ['id' => $id])->fetch();	

		return $info;
	}

	$info = book_info($pdo, $book_id);

// Closing PHP tag  ?> 

<!DOCTYPE>
<html>

	<head>
		<meta charset="UTF-8">
  		<meta name="viewport" content="width=device-width, initial-scale=1.0">
  		<title>book Inventory</title>
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
			<!-- 
			  -- TO DO: Fill in ALL the placeholders for this toy from the db
  			  -->
			
			<div class="toy-details-container">
				
				<div class="toy-details">

					<!-- Display title of book -->
			        <h1><?= $info['title'] ?></h1>

			        <hr />

			        <h3>Book Information</h3>

			        <!-- Display authors -->
			        <p><strong>Authors:</strong> <?= $info['authors'] ?></p>

			        <!-- Display average rating -->
			        <p><strong>Average Rating:</strong>  <?= $info['avg_rating'] ?></p>

			        <!-- Display ISBN -->
			        <p><strong>ISBN:</strong> <?= $info['ISBN'] ?></p>

			        <!-- Display page count -->
			        <p><strong>Number of Pages:</strong> <?= $info['page_count'] ?></p>

				<p><strong>Publisher:</strong> <?= $info['publisher'] ?></p>			        
				
				<p><strong>Year Published:</strong> <?= $info['year_published'] ?></p>

			    </div>
			</div>
		</main>

	</body>
</html>
