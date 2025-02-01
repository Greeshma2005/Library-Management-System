<?php
	session_start();
	$connection = mysqli_connect("localhost", "root", "", "lms");
	$book_name = "";
	$book_no = "";
	$author_name = "";
	$cat_name = "";
	$book_price = "";
	$query = "SELECT * FROM books WHERE book_no = '".$_GET['bn']."'";
	$query_run = mysqli_query($connection, $query);
	while ($row = mysqli_fetch_assoc($query_run)) {
		$book_name = $row['book_name'];
		$book_no = $row['book_no'];
		$author_name = $row['author_name'];
		$cat_name = $row['cat_name'];
		$book_price = $row['book_price'];
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit Books</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .form-container {
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="admin_dashboard.php">Library Management System</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="admin_dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link text-white"><strong>Welcome: <?php echo $_SESSION['name']; ?></strong></span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link text-white"><strong>Email: <?php echo $_SESSION['email']; ?></strong></span>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">My Profile</a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="view_profile.php">View Profile</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="edit_profile.php">Edit Profile</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="change_password.php">Change Password</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav><br>
	<span class="marquee"><marquee>Library opens at 8:00 AM and closes at 8:00 PM</marquee></span>
	<div class="container form-container">
		<center><h4>Edit Book</h4></center>
		<div class="row justify-content-center">
			<div class="col-md-6">
				<form action="" method="post">
					<div class="form-group">
						<label for="book_no">ISBN Number:</label>
						<input type="text" name="book_no" value="<?php echo $book_no; ?>" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="book_name">Book Name:</label>
						<input type="text" name="book_name" value="<?php echo $book_name; ?>" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="author_id">Author Name:</label>
						<input type="text" name="author_name" value="<?php echo $author_name; ?>" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="cat_id">Branch Name:</label>
						<input type="text" name="cat_name" value="<?php echo $cat_name; ?>" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="book_price">Book Price:</label>
						<input type="text" name="book_price" value="<?php echo $book_price; ?>" class="form-control" required>
					</div>
					<button type="submit" name="update" class="btn btn-primary">Update Book</button>
				</form>
			</div>
		</div>
	</div>
</body>
</html>
<?php
	if(isset($_POST['update'])){
		$original_book_no = $_GET['bn']; 
		$new_book_no = $_POST['book_no']; 
		
		$query = "UPDATE books SET 
			book_no = '$new_book_no', 
			book_name = '".$_POST['book_name']."', 
			author_name = '".$_POST['author_name']."', 
			cat_name = '".$_POST['cat_name']."', 
			book_price = '".$_POST['book_price']."' 
		WHERE book_no = '$original_book_no'";
		
		$query_run = mysqli_query($connection, $query);
		
		if ($query_run) {
			echo "<script>alert('Book updated successfully!'); window.location.href='manage_book.php';</script>";
		} else {
			echo "<script>alert('Error updating book. Please try again.');</script>";
		}
	}
?>
