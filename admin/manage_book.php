<?php
require("functions.php");
session_start();
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, "lms");
$name = $email = $mobile = "";
$query = "SELECT * FROM admins WHERE email = '$_SESSION[email]'";
$query_run = mysqli_query($connection, $query);
while ($row = mysqli_fetch_assoc($query_run)) {
    $name = $row['name'];
    $email = $row['email'];
    $mobile = $row['mobile'];
}
$search = "";
$query = "SELECT * FROM books";
$searchPerformed = false;
if (isset($_POST['search'])) {
    $search = mysqli_real_escape_string($connection, $_POST['search']);
    if (!empty($search)) {
        $query .= " WHERE book_name LIKE '%$search%' OR author_name LIKE '%$search%' OR cat_name LIKE '%$search%'";
        $searchPerformed = true;
    }
}
$query_run = mysqli_query($connection, $query);
$booksAvailable = mysqli_num_rows($query_run) > 0;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Book</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .navbar .dropdown-menu {
            left: auto;
            right: 0;
        }
        .btn-group {
            margin-top: 10px;
        }
        .no-books-message {
            text-align: center;
            margin: 20px 0;
            font-size: 1.5em;
            color: #dc3545; 
        }
        .search-form {
            width: 100%;
            max-width: 600px;
            margin: auto;
        }
        .form-control::placeholder {
            color: #6c757d;
        }
        .cancel-btn {
            margin-left: 10px;
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
    <?php if ($booksAvailable) { ?>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <center><h4>Manage Books</h4><br></center>
                <div class="d-flex justify-content-center">
                    <form method="POST" class="form-inline my-2 my-lg-0 search-form">
                        <div class="form-row w-100">
                            <div class="col">
                                <input type="text" name="search" class="form-control w-100" placeholder="Search by book name, author name, or branch name" value="<?php echo htmlspecialchars($search); ?>">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary mb-2">Search</button>
                            </div>
                            <?php if ($searchPerformed) { ?>
                                <div class="col-auto">
                                    <a href="manage_book.php" class="btn btn-secondary mb-2 cancel-btn">Cancel</a>
                                </div>
                            <?php } ?>
                        </div>
                    </form>
                </div>
                <br><br>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Book Name</th>
                                <th>Author Name</th>
                                <th>Branch Name</th>
                                <th>ISBN Number</th>
                                <th>Book Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($query_run)) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['book_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['author_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['cat_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['book_no']); ?></td>
                                    <td><?php echo htmlspecialchars($row['book_price']); ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <a class="btn btn-primary mr-2" href="edit_book.php?bn=<?php echo htmlspecialchars($row['book_no']); ?>">Edit</a>
                                            <a class="btn btn-danger" href="delete_book.php?bn=<?php echo htmlspecialchars($row['book_no']); ?>">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <p class="no-books-message">
                    <?php echo $searchPerformed ? 'No Book Matches the Search Criteria' : 'No Book Is Available'; ?>
                </p>
            </div>
        </div>
    <?php } ?>
</div>
</body>
</html>
