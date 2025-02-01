<?php
$connection = mysqli_connect("localhost", "root", "", "lms");
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $student_id = mysqli_real_escape_string($connection, $_POST['student_id']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    $mobile = mysqli_real_escape_string($connection, $_POST['mobile']);
    $address = mysqli_real_escape_string($connection, $_POST['address']);
    $check_query = "SELECT * FROM users WHERE student_id='$student_id'";
    $check_result = mysqli_query($connection, $check_query);
    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Student ID already registered. You can login now!!'); window.location.href = 'index.php';</script>";
    } else {
        $email_check_query = "SELECT * FROM users WHERE email='$email'";
        $email_check_result = mysqli_query($connection, $email_check_query);
        if (mysqli_num_rows($email_check_result) > 0) {
            echo "<script>alert('Email already registered.'); window.location.href = 'signup.php';</script>";
        } else {
            $query = "INSERT INTO users (name, email, student_id, password, mobile, address) VALUES ('$name', '$email', '$student_id', '$password', '$mobile', '$address')";
            if (mysqli_query($connection, $query)) {
                echo "<script>alert('Registration successful. You may log in now!'); window.location.href = 'index.php';</script>";
            } else {
                echo "Error: " . mysqli_error($connection);
            }
        }
    }
    mysqli_close($connection);
}
?>
