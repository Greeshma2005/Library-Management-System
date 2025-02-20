<?php
session_start();
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, "lms");
$name = "";
$email = "";
$student_id = "";
$mobile = "";
$address = "";
$query = "SELECT * FROM users WHERE student_id != 0";
$searchPerformed = false;
$usersAvailable = false;
if (isset($_POST['search'])) {
    $search = mysqli_real_escape_string($connection, $_POST['search']);
    $query .= " AND (name LIKE '%$search%' OR email LIKE '%$search%')";
    $searchPerformed = true;
}
$query_run = mysqli_query($connection, $query);
$usersAvailable = mysqli_num_rows($query_run) > 0;
$initialCheckQuery = "SELECT COUNT(*) as total FROM users WHERE student_id != 0";
$initialCheckRun = mysqli_query($connection, $initialCheckQuery);
$initialCheckRow = mysqli_fetch_assoc($initialCheckRun);
$initialUsersAvailable = $initialCheckRow['total'] > 0;
?>
<!DOCTYPE html>
<html>
<head>
    <title>All Reg Users</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        body {
            overflow-x: hidden; 
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
    </nav>
    <span><marquee>Library opens at 8:00 AM and closes at 8:00 PM</marquee></span><br><br>
    <?php if ($initialUsersAvailable) { ?>
        <center><h4>Registered Users Detail</h4><br></center>
        <div class="container">
            <div class="d-flex justify-content-center">
                <form method="POST" class="form-inline my-2 my-lg-0 search-form">
                    <div class="form-row w-100">
                        <div class="col">
                            <input type="text" name="search" class="form-control w-100" placeholder="Search by name or email" value="<?php echo htmlspecialchars($_POST['search'] ?? ''); ?>">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary mb-2">Search</button>
                        </div>
                        <?php if ($searchPerformed) { ?>
                        <div class="col-auto">
                            <a href="Regusers.php" class="btn btn-secondary mb-2 cancel-btn">Cancel</a>
                        </div>
                        <?php } ?>
                    </div>
                </form>
            </div>
            <br><br>
            <div class="table-responsive">
                <?php if ($usersAvailable) { ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Student ID</th>
                                <th>Mobile</th>
                                <th>Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_assoc($query_run)) {
                                $name = $row['name'];
                                $email = $row['email'];
                                $student_id = $row['student_id'];
                                $mobile = $row['mobile'];
                                $address = $row['address'];
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($name); ?></td>
                                <td><?php echo htmlspecialchars($email); ?></td>
                                <td><?php echo htmlspecialchars($student_id); ?></td>
                                <td><?php echo htmlspecialchars($mobile); ?></td>
                                <td><?php echo htmlspecialchars($address); ?></td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <p class="no-books-message"><?php echo $searchPerformed ? 'No users found.' : 'No Registered Users'; ?></p>
                <?php } ?>
            </div>
        </div>
    <?php } else { ?>
        <center><h4 class="no-books-message">No Registered Users</h4></center>
    <?php } ?>
</body>
</html>

<?php
mysqli_close($connection);
?>
