<?php
session_start();
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, "lms");

if (isset($_POST['update'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $query = "SELECT password FROM users WHERE email = '$_SESSION[email]'";
    $query_run = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($query_run);
    if ($row) {
        $current_password = $row['password'];
        if ($current_password == $old_password) {
            $update_query = "UPDATE users SET password = '$new_password' WHERE email = '$_SESSION[email]'";
            $update_query_run = mysqli_query($connection, $update_query);
            if ($update_query_run) {
                echo "<script>alert('Password updated successfully');</script>";
                echo "<script>window.location.href='user_dashboard.php';</script>";
            } else {
                echo "<script>alert('Failed to update password');</script>";
                echo "<script>window.location.href='update_password.php';</script>";
            }
        } else {
            echo "<script>alert('Old password is incorrect');</script>";
            echo "<script>window.location.href='update_password.php';</script>";
        }
    } else {
        echo "<script>alert('User not found');</script>";
        echo "<script>window.location.href='update_password.php';</script>";
    }
}
?>

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
                        <a class="nav-link" href="user_dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link text-white"><strong>Welcome: <?php echo $_SESSION['name'];?></strong></span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link text-white"><strong>Email: <?php echo $_SESSION['email'];?></strong></span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link text-white"><strong>Student ID: <?php echo $_SESSION['student_id'];?></strong></span>
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
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <center><h4>Change Student Password</h4></center><br>
                <form action="update_password.php" method="post">
                    <div class="form-group">
                        <label for="password">Enter Old Password:</label>
                        <input type="password" class="form-control" name="old_password" required>
                    </div>
                    <div class="form-group">
                        <label for="new_password">Enter New Password:</label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>
                    <button type="submit" name="update" class="btn btn-primary">Update Password</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>