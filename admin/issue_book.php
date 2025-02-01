<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Issue Book</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .navbar .dropdown-menu {
            left: auto;
            right: 0;
        }
    </style>
    <script type="text/javascript">
        function alertMsg() {
            alert("Book issued successfully...");
            window.location.href = "admin_dashboard.php";
        }
    </script>
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
</nav> <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav2" aria-controls="navbarNav2" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav2">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="admin_dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" role="button" data-toggle="dropdown">Books</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="add_book.php">Add New Book</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="manage_book.php">Manage Books</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" role="button" data-toggle="dropdown">Branch</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="add_cat.php">Add New Branch</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="manage_cat.php">Manage Branch</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" role="button" data-toggle="dropdown">Authors</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="add_author.php">Add New Author</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="manage_author.php">Manage Author</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="issue_book.php">Issue Book</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav><br>
<span><marquee>Library opens at 8:00 AM and close at 8:00 PM</marquee></span><br><br>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <center><h4>Issue Book</h4></center><br>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-4">
            <form action="" method="post">
                <div class="form-group">
                    <label for="student_id">Student ID:</label>
                    <input type="text" name="student_id" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="student_name">Student Name:</label>
                    <input type="text" name="student_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="book_name">Book Name:</label>
                    <input type="text" name="book_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="book_author">Author Name:</label>
                    <input type="text" name="book_author" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="book_no">ISBN Number:</label>
                    <input type="text" name="book_no" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="issue_date">Issue Date:</label>
                    <input type="text" name="issue_date" class="form-control" value="<?php echo date("d-m-Y"); ?>" readonly>
                </div>
                <div class="text-center">
                    <button type="submit" name="issue_book" class="btn btn-primary">Issue Book</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>

<?php
    if (isset($_POST['issue_book'])) {
        $connection = mysqli_connect("localhost", "root", "", "lms");
        if (!$connection) {
            die("Database connection failed: " . mysqli_connect_error());
        }

        $student_id = mysqli_real_escape_string($connection, $_POST['student_id']);
        $student_name = mysqli_real_escape_string($connection, $_POST['student_name']);
        $book_no = mysqli_real_escape_string($connection, $_POST['book_no']);
        $book_name = mysqli_real_escape_string($connection, $_POST['book_name']);
        $book_author = mysqli_real_escape_string($connection, $_POST['book_author']);
        $issue_date = mysqli_real_escape_string($connection, $_POST['issue_date']);
        $query_check_student = "SELECT id FROM users WHERE id = '$student_id'";
        $result_check_student = mysqli_query($connection, $query_check_student);
        if (mysqli_num_rows($result_check_student) == 0) {
            $query_insert_student = "INSERT INTO users (id, name) VALUES ('$student_id', '$student_name')";
            mysqli_query($connection, $query_insert_student);
        }
        $query = "INSERT INTO issued_books (student_id,student_name,book_name, book_author,book_no,issue_date,status) VALUES ( '$student_id','$student_name','$book_name', '$book_author','$book_no','$issue_date',1)";
        if (mysqli_query($connection, $query)) {
            echo "<script>alertMsg();</script>";
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($connection);
        }

        mysqli_close($connection);
    }
?>