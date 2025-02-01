<?php
session_start();
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, "lms");
$search = "";
$query = "SELECT * FROM category";
$searchPerformed = false;
$branchesAvailable = false;
if (isset($_POST['search'])) {
    $search = mysqli_real_escape_string($connection, $_POST['search']);
    if (!empty($search)) {
        $query .= " WHERE cat_name LIKE '%$search%'";
        $searchPerformed = true;
    }
}
$query_run = mysqli_query($connection, $query);
$branchesAvailable = mysqli_num_rows($query_run) > 0;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Book's Category</title>
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
        .no-branches-message {
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
    </nav>
    <br>
    <span><marquee>Library opens at 8:00 AM and closes at 8:00 PM</marquee></span><br><br>
    <div class="container">
    <?php if ($branchesAvailable || $searchPerformed) { ?>
        <center><h4>Available Branches</h4><br></center>
            <div class="d-flex justify-content-center">
                <form method="POST" class="form-inline my-2 my-lg-0 search-form">
                    <div class="form-row w-100">
                        <div class="col">
                            <input type="text" name="search" class="form-control w-100" placeholder="Search by branch name" value="<?php echo htmlspecialchars($search); ?>">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary mb-2">Search</button>
                        </div>
                        <?php if ($searchPerformed) { ?>
                            <div class="col-auto">
                                <a href="Regcat.php" class="btn btn-secondary mb-2 cancel-btn">Cancel</a>
                            </div>
                        <?php } ?>
                    </div>
                </form>
            </div>
            <br><br>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="table-responsive">
                        <?php if ($branchesAvailable) { ?>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Branch Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($query_run)) {
                                        ?>
                                        <tr>
                                            <td>
                                                <form action="branch_books.php" method="POST" style="display: inline;">
                                                    <input type="hidden" name="cat_name" value="<?php echo htmlspecialchars($row['cat_name']); ?>">
                                                    <button type="submit" class="btn btn-link text-decoration-none"><?php echo htmlspecialchars($row['cat_name']); ?></button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        <?php } else { ?>
                            <p class="no-branches-message"><?php echo $searchPerformed ? 'Branch Is Not Available' : 'No Branches Available'; ?></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <center><h4 class="no-branches-message">No Branches Are Available</h4></center>
    <?php } ?>
</body>
</html>

<?php
mysqli_close($connection);
?>
