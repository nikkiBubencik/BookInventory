<?php   										// Opening PHP tag
	
	// Include the database connection script
	require 'includes/database-connection.php';

	  $bookID = $_GET['bookID'];

	function add_review(PDO $pdo, $bookID, string  $review_text, $rating, $userId){
		// start transaction
	    // $pdo->beginTransaction();
	    // add user to group
	    // $AddReviewSQL = "INSERT INTO reviews (bookID, review_text, userID, rating, date_added) VALUES (:bookID, :review_text, :userId, :rating, CURDATE());";
	    // $stmt = pdo($pdo, $AddReviewSQL, ['bookID' => $bookID, 'review_text' => $review_text, 'userID' => $userId, 'rating' => $rating]); 
		echo "userID " . $userID . " Date " . CURDATE();
	    // Commit transaction
	    // $pdo->commit();
	}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submitNewReview'])) {
        $review_text = $_POST['review_text'];
        $rating = $_POST['rating'];
      // *** CHANGE FROM '1' TO USERID
        add_review($pdo, $bookID, $review_text, $rating, 1); 
        
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

			<div class="group-add-container">
				<div class="group-add-container">
					<h1>Add Review</h1>
					<form action="add-review.php?bookID=<?= $bookID ?>" method="POST">
              <div class="form-group">
                  <label for="review_text">Review:</label>
                  <input type="text" id="review_text" name="review_text" required>
              </div>
              <div class="form-group">
                  <label for="rating">Rating:</label>
                  <input type="text" id="rating" name="rating" required>
              </div>

              <button type="submit" name="submitNewReview">Add Reviewr</button>
          </form>
				</div>	
           				<?php if(isset($_POST['submitNewReview'])): ?>
					            <p> Review Added</p>
					<?php endif; ?> 

			</div>

		</main>

	</body>

</html>
