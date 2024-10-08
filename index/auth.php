<?php
session_start(); // Start the session at the top
include 'db.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user input
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $password = trim(mysqli_real_escape_string($conn, $_POST['password']));

    // Fetch user details from the database
    $sql = "SELECT * FROM user WHERE name = '$name'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User exists, now verify the password
        $row = $result->fetch_assoc();

        // Check if the password matches the hashed password
        if (password_verify($password, $row['password'])) {
            // Password is correct, create session
            $_SESSION['name'] = $name;
            // Redirect to welcome page
            header("Location: welcome.php");
            exit(); // Always exit after redirect
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that name.";
    }
}
?>
