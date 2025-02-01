<?php
session_start();
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, "lms");

if (isset($_POST['update'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $query = "SELECT password FROM admins WHERE email = '$_SESSION[email]'";
    $query_run = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($query_run);
    if ($row) {
        $current_password = $row['password'];
        if ($current_password == $old_password) {
            $update_query = "UPDATE admins SET password = '$new_password' WHERE email = '$_SESSION[email]'";
            $update_query_run = mysqli_query($connection, $update_query);
            if ($update_query_run) {
                echo "<script>alert('Password updated successfully');</script>";
                echo "<script>window.location.href='change_password.php';</script>";
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