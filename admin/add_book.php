<?php
    require("functions.php");
    session_start();
    $connection = mysqli_connect("localhost", "root", "", "lms");
    if (!$connection) {
        die("Database connection failed: " . mysqli_connect_error());
    }
    $name = $email = $mobile = "";
    $query = "SELECT * FROM admins WHERE email = '$_SESSION[email]'";
    $query_run = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($query_run)) {
        $name = $row['name'];
        $email = $row['email'];
        $mobile = $row['mobile'];
    }
    $book_added = false;
    $duplicate_book = false;
    if (isset($_POST['add_book'])) {
        $book_name = $_POST['book_name'];
        $author_name = $_POST['author_name'];
        $cat_name = $_POST['cat_name'];
        $count_books = $_POST['count_books'];
        $book_no = $_POST['book_no'];
        $book_price = $_POST['book_price'];
        $check_query = "SELECT * FROM books WHERE book_name = '$book_name' AND author_name = '$author_name' AND book_no = '$book_no'";
        $check_query_run = mysqli_query($connection, $check_query);
        if (mysqli_num_rows($check_query_run) > 0) {
            $duplicate_book = true;
        } else {
            $query = "INSERT INTO books VALUES (NULL, '$book_name', '$author_name', '$cat_name', '$count_books' ,'$book_no', '$book_price')";
            if (mysqli_query($connection, $query)) {
                $book_added = true;
            }
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add New Book</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
        function alertMsg(msg) {
            alert(msg);
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
                        <span class="nav-link text-white"><strong>Welcome: <?php echo $_SESSION['name'];?></strong></span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link text-white"><strong>Email: <?php echo $_SESSION['email'];?></strong></span>
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
    </nav>
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd">
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
    <span><marquee>Library opens at 8:00 AM and closes at 8:00 PM</marquee></span><br><br>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <center><h4>Add a New Book</h4><br></center>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="book_name">Book Name:</label>
                        <input type="text" name="book_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="author_name">Author Name:</label>
                        <input type="text" name="author_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="cat_name">Branch Name:</label>
                        <input type="text" name="cat_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="count_books">No. of Books Available:</label>
                        <input type="text" name="count_books" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="book_no">ISBN Number:</label>
                        <input type="text" name="book_no" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="book_price">Book Price:</label>
                        <input type="text" name="book_price" class="form-control" required>
                    </div>
                    <button type="submit" name="add_book" class="btn btn-primary">Add Book</button>
                </form>
            </div>
        </div>
    </div>
    <?php
        if ($book_added) {
            echo "<script>alertMsg('Book added successfully...');</script>";
        }
        if ($duplicate_book) {
            echo "<script>alertMsg('Book already added!');</script>";
        }
    ?>
</body>
</html>
