<?php
session_start();
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, "lms");
$query = "SELECT book_name, book_no, book_price, author_name, cat_name, count_books FROM books";
$searchPerformed = false;
$booksAvailable = false;
if (isset($_POST['search'])) {
    $search = mysqli_real_escape_string($connection, $_POST['search']);
    $query .= " WHERE book_name LIKE '%$search%' OR author_name LIKE '%$search%'";
    $searchPerformed = true;
}
$query_run = mysqli_query($connection, $query);
$booksAvailable = mysqli_num_rows($query_run) > 0;

$initialCheckQuery = "SELECT COUNT(*) as total FROM books";
$initialCheckRun = mysqli_query($connection, $initialCheckQuery);
$initialCheckRow = mysqli_fetch_assoc($initialCheckRun);
$initialBooksAvailable = $initialCheckRow['total'] > 0;
?>
<!DOCTYPE html>
<html>
<head>
    <title>All Registered Books</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
    body {
        overflow-x: hidden;
    }
    table {
        width: 100%;
    }
    table th, table td {
        text-align: center;
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
    .no-books-message {
        text-align: center;
        margin: 20px 0;
        font-size: 1.5em;
        color: #dc3545; 
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
    <span><marquee>Library opens at 8:00 AM and closes at 8:00 PM</marquee></span><br><br>
    <?php if ($initialBooksAvailable) { ?>
        <center><h4>Registered Book's Detail</h4><br></center>
        <div class="container">
            <div class="d-flex justify-content-center">
                <form method="POST" class="form-inline my-2 my-lg-0 search-form">
                    <div class="form-row w-100">
                        <div class="col">
                            <input type="text" name="search" class="form-control w-100" placeholder="Search by book name or author" value="<?php echo htmlspecialchars($_POST['search'] ?? ''); ?>">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary mb-2">Search</button>
                        </div>
                        <?php if ($searchPerformed) { ?>
                        <div class="col-auto">
                            <a href="Regbooks.php" class="btn btn-secondary mb-2 cancel-btn">Cancel</a>
                        </div>
                        <?php } ?>
                    </div>
                </form>
            </div>
            <br><br>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <?php if ($booksAvailable) { ?>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Book Name</th>
                                        <th>Author Name</th>
                                        <th>Branch</th>
                                        <th>No. of Books Available</th>
                                        <th>Book Price</th>
                                        <th>ISBN Number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($query_run)) {
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['book_name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['author_name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['cat_name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['count_books']); ?></td>
                                            <td><?php echo htmlspecialchars($row['book_price']); ?></td>
                                            <td><?php echo htmlspecialchars($row['book_no']); ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        <?php } else { ?>
                            <p class="no-books-message"><?php echo $searchPerformed ? 'Book is not available.' : 'No Books Are Available'; ?></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <center><h4 class="no-books-message">No Books Are Available</h4></center>
    <?php } ?>
</body>
</html>