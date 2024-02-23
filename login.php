<?php
include 'config.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT id, username, email, password FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header("Location: tasks.php");
            exit();
        } else {
            echo "<script>alert('invalid email or password');window.location='login.html';</script>";
        }
    } else {
        echo "<script>alert('invalid email or password');window.location='login.html';</script>";
    }
}
$conn->close();
?>
