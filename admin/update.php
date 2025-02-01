<?php
    session_start();
    $connection = mysqli_connect("localhost", "root", "", "lms");

    if (isset($_POST['update'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];

        $query = "UPDATE admins SET name='$name', email='$email', mobile='$mobile' WHERE email='$_SESSION[email]'";
        $query_run = mysqli_query($connection, $query);

        if ($query_run) {
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            $_SESSION['mobile'] = $mobile;

            echo "<script>
                    alert('Profile updated successfully');
                    window.location.href = 'edit_profile.php';
                  </script>";
        } else {
            echo "<script>alert('Profile update failed');</script>";
        }
    }
?>
