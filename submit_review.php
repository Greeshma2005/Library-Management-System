<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    die("Session variable 'student_id' is not set. Please log in.");
}

$connection = mysqli_connect("localhost", "root", "", "lms");
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

$submission_message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $review = mysqli_real_escape_string($connection, $_POST['review']);
    $rating = intval($_POST['rating']);
    $student_id = mysqli_real_escape_string($connection, $_SESSION['student_id']);
    if ($rating < 1 || $rating > 5) {
        die("Invalid rating value.");
    }
    $query = "INSERT INTO feedback (student_id, feedback_text, rating) VALUES ('$student_id', '$review', $rating)";
    $query_run = mysqli_query($connection, $query);
    
    if ($query_run) {
        $submission_message = "Thank you for submitting your feedback!";
    } else {
        $submission_message = "Error submitting feedback.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Submit Review</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            font-family: "Poppins", sans-serif;
        }
        
        .navbar {
            margin-bottom: 20px; 
        }

        .container {
            max-width: 600px;
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: auto; 
        }
        
        .star {
            font-size: 3rem;
            cursor: pointer;
            color: #ccc;
        }
        
        .star.filled {
            color: #f5b301;
        }

        .message {
            margin-top: 1rem;
            font-size: 1.1rem;
            color: #28a745;
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
                        <a class="nav-link" href="user_dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link text-white"><strong>Welcome: <?php echo htmlspecialchars($_SESSION['name']); ?></strong></span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link text-white"><strong>Email: <?php echo htmlspecialchars($_SESSION['email']); ?></strong></span>
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
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <h2 class="mt-4 text-center">Submit Review & Rating</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="review">Your Review:</label>
                <textarea name="review" id="review" class="form-control" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="rating">Your Rating:</label>
                <div class="star-rating text-center">
                    <span onclick="rate(1)" class="star">&#9733;</span>
                    <span onclick="rate(2)" class="star">&#9733;</span>
                    <span onclick="rate(3)" class="star">&#9733;</span>
                    <span onclick="rate(4)" class="star">&#9733;</span>
                    <span onclick="rate(5)" class="star">&#9733;</span>
                </div>
                <input type="hidden" name="rating" id="rating" value="0">
            </div>
            <button type="submit" class="btn btn-success">Submit Feedback</button>
            <?php if ($submission_message): ?>
                <div class="message text-center"><?php echo htmlspecialchars($submission_message); ?></div>
            <?php endif; ?>
        </form>
    </div>
    <script>
        function rate(value) {
            const stars = document.getElementsByClassName('star');
            for (let i = 0; i < stars.length; i++) {
                if (i < value) {
                    stars[i].classList.add('filled');
                } else {
                    stars[i].classList.remove('filled');
                }
            }
            document.getElementById('rating').value = value;
        }
    </script>
</body>
</html>
