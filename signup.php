<!DOCTYPE html>
<html>
<head>
	<title>LIBRARY MANAGEMENT SYSTEM</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<style type="text/css">
	#main_content {
		padding: 50px;
		background-color: whitesmoke;
	}
	#side_bar {
		background-color: whitesmoke;
		padding: 20px;
		width: 100%;
	}
	@media (min-width: 768px) {
		#side_bar {
			width: 300px;
			height: 450px;
		}
	}
</style>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container-fluid">
			<a class="navbar-brand" href="index.php">Library Management System (LMS)</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item">
						<a class="nav-link" href="admin/index.php">Admin Login</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="signup.php">Register</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="index.php">Login</a>
					</li>
				</ul>
			</div>
		</div>
	</nav><br>
	<span><marquee>Library opens at 8:00 AM and closes at 8:00 PM</marquee></span><br><br>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-4" id="side_bar">
				<h5>Library Timings</h5>
				<ul>
					<li>Opening: 8:00 AM</li>
					<li>Closing: 8:00 PM</li>
					<li>(Sunday Off)</li>
				</ul>
				<h5>What We Provide?</h5>
				<ul>
					<li>Full furniture</li>
					<li>Free Wi-fi</li>
					<li>Newspapers</li>
					<li>Discussion Room</li>
					<li>Digital Library</li>
					<li>Peaceful Environment</li>
				</ul>
			</div>
		<div class="col-md-8" id="main_content">
			<center><h3>User Registration Form</h3></center>
			<form action="register.php" method="post">
				<div class="form-group">
					<label for="name">Full Name:</label>
					<input type="text" name="name" class="form-control" required>
				</div>
				<div class="form-group">
					<label for="email">Email ID:</label>
					<input type="email" name="email" class="form-control" required>
				</div>
				<div class="form-group">
						<label for="student_id">Student ID:</label>
						<input type="text" name="student_id" class="form-control" required>
				</div>
				<div class="form-group">
					<label for="password">Password:</label>
					<input type="password" name="password" class="form-control" required>
				</div>
				<div class="form-group">
					<label for="mobile">Mobile:</label>
					<input type="text" name="mobile" class="form-control" required>
				</div>
				<div class="form-group">
					<label for="address">Address:</label>
					<textarea name="address" class="form-control" required></textarea> 
				</div>
				<button type="submit" class="btn btn-primary">Register</button>	
			</form>
		</div>
	</div>
</body>
</html>