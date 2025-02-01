<?php
session_start();
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, "lms");
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $student_id = $_POST['student_id'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];
    $query = "UPDATE users SET name='$name', email='$email', student_id='$student_id', mobile='$mobile', address='$address' WHERE email='$_SESSION[email]'";
    $query_run = mysqli_query($connection, $query);
    if ($query_run) {
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['student_id'] = $student_id;
        $_SESSION['mobile'] = $mobile;
        $_SESSION['address'] = $address;
        echo "<script>alert('Profile updated successfully');</script>";
        echo "<script>window.location.href='user_dashboard.php';</script>";
    } else {
        echo "<script>alert('Profile update failed');</script>";
        echo "<script>window.location.href='edit_profile.php';</script>";
    }
}
?>
