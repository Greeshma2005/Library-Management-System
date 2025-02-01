<?php
	session_start();
	$connection = mysqli_connect("localhost", "root", "", "lms");
	$cat_id = $cat_name = "";
	$query = "SELECT * FROM category WHERE cat_id = $_GET[cid]";
	$query_run = mysqli_query($connection, $query);
	while ($row = mysqli_fetch_assoc($query_run)) {
		$cat_name = $row['cat_name'];
		$cat_id = $row['cat_id'];
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit Branch</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
	<span><marquee>Library opens at 8:00 AM and closes at 8:00 PM</marquee></span><br><br>
	<div class="container form-container">
		<div class="row">
			<div class="col-md-8 offset-md-2">
				<div class="card">
					<div class="card-header">
						<center><h4>Edit Branch</h4></center>
					</div>
					<div class="card-body">
						<form action="" method="post">
							<div class="form-group">
								<label for="name">Branch Name:</label>
								<input type="text" class="form-control" name="cat_name" value="<?php echo $cat_name; ?>" required>
							</div>
							<button type="submit" name="update_cat" class="btn btn-primary btn-block">Update Branch</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
		if (isset($_POST['update_cat'])) {
			$connection = mysqli_connect("localhost", "root", "", "lms");
			$query = "UPDATE category SET cat_name = '$_POST[cat_name]' WHERE cat_id = $_GET[cid]";
			$query_run = mysqli_query($connection, $query);
		if ($query_run) {
			echo "<script>alert('Branch updated successfully!'); window.location.href='manage_cat.php';</script>";
		} else {
			echo "<script>alert('Error updating branch. Please try again.');</script>";
		}
		}
	?>
</body>
</html>
