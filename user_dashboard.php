<?php
session_start();
function get_user_issue_book_count(){
    $connection = mysqli_connect("localhost","root","");
    $db = mysqli_select_db($connection,"lms");
    $user_issue_book_count = 0;
    $query = "SELECT COUNT(*) AS user_issue_book_count FROM issued_books WHERE student_id = '" . $_SESSION['student_id'] . "'";
    $query_run = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($query_run)){
        $user_issue_book_count = $row['user_issue_book_count'];
    }
    return $user_issue_book_count;
}
function get_category_count(){
    $connection = mysqli_connect("localhost","root","");
    $db = mysqli_select_db($connection,"lms");
    $cat_count = 0;
    $query = "SELECT COUNT(*) AS cat_count FROM category";
    $query_run = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($query_run)){
        $cat_count = $row['cat_count'];
    }
    return $cat_count;
}
function check_due_remainder(){
    $connection = mysqli_connect("localhost", "root", "", "lms");
    $student_id = $_SESSION['student_id'];
    $message = '';

    $query = "SELECT issue_date FROM issued_books WHERE student_id = '$student_id' AND status = 1";
    $query_run = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($query_run)) {
        $issue_date = new DateTime($row['issue_date']);
        $current_date = new DateTime();
        $interval = $current_date->diff($issue_date);
        $days_passed = $interval->days;

        if ($days_passed > 15) {
            $overdue_days = $days_passed - 15;
            $message = 'You have overdue books! Please check your issued books.';
            break; 
        } elseif ($days_passed == 14) {
            $message = 'Reminder: One of your issued books is due tomorrow.';
        } elseif ($days_passed == 15) {
            $message = 'Reminder: One of your issued books is due today!';
        }
    }
    return $message;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .card-custom {
            margin-bottom: 20px;
        }
        .alert-dismissible .close {
            position: absolute;
            top: 0;
            right: 0;
            padding: 0.75rem 1.25rem;
            margin: -0.75rem -1.25rem -0.75rem auto;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="user_dashboard.php">Library Management System</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <span class="nav-link text-white"><strong>Welcome: <?php echo htmlspecialchars($_SESSION['name']);?></strong></span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link text-white"><strong>Email: <?php echo htmlspecialchars($_SESSION['email']);?></strong></span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link text-white"><strong>Student ID: <?php echo htmlspecialchars($_SESSION['student_id']);?></strong></span>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">My Profile</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="view_profile.php">View Profile</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="edit_profile.php">Edit Profile</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="update_password.php">Change Password</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav><br>
    <span><marquee>Library opens at 8:00 AM and closes at 8:00 PM</marquee></span><br><br>
    
    <!-- Display overdue remainder message here -->
    <div class="container">
        <?php
        $due_message = check_due_remainder();
        if (!empty($due_message)) {
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
            echo htmlspecialchars($due_message);
            echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
            echo '<span aria-hidden="true">&times;</span>';
            echo '</button>';
            echo '</div>';
        }
        ?>
        
        <div class="row">
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="card bg-light card-custom">
                    <div class="card-header">Issued Books</div>
                    <div class="card-body">
                        <p class="card-text">No.of books issued: <?php echo get_user_issue_book_count();?></p>
                        <a class="btn btn-success" href="view_issued_book.php">View Issued Books</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="card bg-light card-custom">
                    <div class="card-header">Branch</div>
                    <div class="card-body">
                        <p class="card-text">No.of branches: <?php echo get_category_count();?></p>
                        <a class="btn btn-warning" href="Regcat.php">View Branches</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="card bg-light card-custom">
                    <div class="card-header">Submit Review</div>
                    <div class="card-body">
                        <p class="card-text">Give your feedback on books and services.</p>
                        <a class="btn btn-info" href="submit_review.php">Submit Review</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
