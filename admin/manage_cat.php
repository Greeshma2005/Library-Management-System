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
$search_term = isset($_POST['search']) ? mysqli_real_escape_string($connection, $_POST['search']) : '';
$query = "SELECT * FROM category";
if (!empty($search_term)) {
    $query .= " WHERE cat_name LIKE '%$search_term%'";
}
$query_run = mysqli_query($connection, $query);
$branchesAvailable = mysqli_num_rows($query_run) > 0;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Branch</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .navbar .dropdown-menu {
            left: auto;
            right: 0;
        }
        .btn-no-underline {
            text-decoration: none;
        }
        .btn-no-underline:hover {
            text-decoration: none;
        }
        .btn-gap {
            margin-right: 5px;
        }
        .no-branches-msg {
            color: #dc3545;
            font-size: 1.25rem;
            text-align: center;
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
</nav>
<br>
<span><marquee>Library opens at 8:00 AM and closes at 8:00 PM</marquee></span>
<br><br>
<div class="container">
    <?php if ($branchesAvailable) { ?>
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h4 class="text-center">Manage Branch</h4><br>
                <form method="post" class="mb-4">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Search Branch" value="<?php echo isset($_POST['search']) ? htmlspecialchars($_POST['search']) : ''; ?>">
                        <div class="input-group-append">
                            <button class="btn btn-primary mr-2" type="submit">Search</button>
                            <?php if (isset($_POST['search']) && !empty($_POST['search'])): ?>
                                <a href="manage_cat.php" class="btn btn-secondary btn-gap">Cancel</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <?php while ($row = mysqli_fetch_assoc($query_run)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['cat_name']); ?></td>
                            <td>
                                <a href="edit_cat.php?cid=<?php echo htmlspecialchars($row['cat_id']); ?>" class="btn btn-primary btn-gap btn-no-underline">Edit</a>
                                <a href="delete_cat.php?cid=<?php echo htmlspecialchars($row['cat_id']); ?>" class="btn btn-danger btn-no-underline">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    <?php } else { ?>
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <p class="no-branches-msg">No Branch Is Available</p>
            </div>
        </div>
    <?php } ?>
</div>
</body>
</html>

<?php
mysqli_close($connection);
?>
