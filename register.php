<?php
include 'config.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if (strlen($username) < 6 || !preg_match("/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^a-zA-Z0-9]).{8,}$/", $username)) {
        echo "Username should conatain atleast 6 characters";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address";
        exit;
    }

    // Check if email already exists
    $email_check_sql = "SELECT * FROM users WHERE username='$username' OR email='$email'";
    $email_check_result = $conn->query($email_check_sql);

    if ($email_check_result->num_rows > 0) {
        // Email already in use, show alert
        echo "<script>alert('User already exist Please Login.');window.location='login.html';</script>";
    } else {
        // Email is unique, proceed with registration
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

        if ($conn->query($sql) === TRUE) {
            // Registration successful, set user ID in session
            $_SESSION['user_id'] = $conn->insert_id; // Get the user ID of the newly registered user
            $_SESSION['username'] = $username;
            header("Location: login.html");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
