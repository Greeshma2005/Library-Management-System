<?php
session_start();
$connection = mysqli_connect("localhost", "root", "", "lms");
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}
$search = "";
$query = "
    SELECT 
        issued_books.book_name,
        issued_books.book_author,
        issued_books.book_no,
        issued_books.student_id,
        issued_books.student_name,
        issued_books.issue_date
    FROM issued_books 
    WHERE issued_books.status = 1
";
$searchPerformed = false;
if (isset($_POST['search'])) {
    $search = mysqli_real_escape_string($connection, $_POST['search']);
    if (!empty($search)) {
        $query .= " AND (issued_books.student_id LIKE '%$search%' OR issued_books.student_name LIKE '%$search%' OR issued_books.book_name LIKE '%$search%' OR issued_books.book_author LIKE '%$search%')";
        $searchPerformed = true;
    }
}
$query_run = mysqli_query($connection, $query);
$booksIssued = mysqli_num_rows($query_run) > 0;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Issued Books</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        body {
            overflow-x: hidden;
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
        .due-warning {
            color: red;
            font-weight: bold;
        }
        .due-soon {
            color: orange;
            font-weight: bold;
        }
        .no-due {
            color: green;
            font-weight: bold;
        }
        .fine {
            color: red;
            font-weight: bold;
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
    <span><marquee>Library opens at 8:00 AM and closes at 8:00 PM</marquee></span><br><br>
    <div class="container">
        <?php if ($booksIssued || $searchPerformed) { ?>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <center><h4>Issued Book's Detail</h4><br></center>
                    <div class="d-flex justify-content-center">
                        <form method="POST" class="form-inline my-2 my-lg-0 search-form">
                            <div class="form-row w-100">
                                <div class="col">
                                    <input type="text" name="search" class="form-control w-100" placeholder="Search by student id, student name, book name, or author" value="<?php echo htmlspecialchars($search); ?>">
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary mb-2">Search</button>
                                </div>
                                <?php if ($searchPerformed) { ?>
                                    <div class="col-auto">
                                        <a href="view_issued_book.php" class="btn btn-secondary mb-2 cancel-btn">Cancel</a>
                                    </div>
                                <?php } ?>
                            </div>
                        </form>
                    </div>
                    <br><br>
                    <?php if ($booksIssued) { ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Student ID</th>
                                        <th>Student Name</th>
                                        <th>Book Name</th>
                                        <th>Author</th>
                                        <th>ISBN Number</th>
                                        <th>Issued Date</th>
                                        <th>Due Remainder</th>
                                        <th>Fine</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($query_run)) { 
                                        $issue_date = new DateTime($row['issue_date']);
                                        $current_date = new DateTime();
                                        $interval = $current_date->diff($issue_date);
                                        $days_passed = $interval->days;
                                        $due_status = '<span class="no-due">No due</span>';
                                        $fine = '₹0';

                                        if ($days_passed > 15) {
                                            $overdue_days = $days_passed - 15;
                                            $due_status = '<span class="due-warning">Overdue by ' . $overdue_days . ' day' . ($overdue_days > 1 ? 's' : '') . '</span>';
                                            $fine = '₹' . $overdue_days;
                                        } elseif ($days_passed == 14) {
                                            $due_status = '<span class="due-soon">Due in 1 day</span>';
                                        } elseif ($days_passed == 15) {
                                            $due_status = '<span class="due-warning">Due today!</span>';
                                        }
                                    ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['student_id']); ?></td>
                                            <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['book_name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['book_author']); ?></td>
                                            <td><?php echo htmlspecialchars($row['book_no']); ?></td>
                                            <td><?php echo date('d-m-Y', strtotime($row['issue_date'])); ?></td>
                                            <td><?php echo $due_status; ?></td>
                                            <td class="fine"><?php echo $fine; ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="edit_issued_book.php?bn=<?php echo htmlspecialchars($row['book_no']); ?>" class="btn btn-primary btn-custom mr-2">Edit</a>
                                                    <a href="delete_issued_book.php?bn=<?php echo htmlspecialchars($row['book_no']); ?>" class="btn btn-danger btn-custom">Delete</a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } else { ?>
                        <p class="no-books-message">No Book Is Issued</p>
                    <?php } ?>
                </div>
            </div>
        <?php } else { ?>
            <center><h4 class="no-books-message">No Issued Books</h4></center>
        <?php } ?>
    </div>
</body>
</html>