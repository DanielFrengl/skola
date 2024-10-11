x<x<<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            background-color: #000; /* Black background */
            color: #fff; /* White text */
            font-family: Arial, sans-serif; /* Font style */
            display: flex; /* Center the form */
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            height: 100vh; /* Full viewport height */
            margin: 0; /* Remove default margin */
        }
        h2 {
            margin-bottom: 20px; /* Spacing below the title */
        }
        form {
            background-color: #1a1a1a; /* Darker background for the form */
            padding: 20px; /* Inner spacing for the form */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); /* Subtle shadow */
        }
        label {
            display: block; /* Stack labels */
            margin-bottom: 5px; /* Space below labels */
        }
        input[type="text"],
        input[type="password"] {
            width: 100%; /* Full width input */
            padding: 10px; /* Inner spacing */
            margin-bottom: 15px; /* Space below inputs */
            border: 1px solid #007bff; /* Blue border */
            border-radius: 4px; /* Rounded corners for inputs */
            background-color: #333; /* Dark background for inputs */
            color: #fff; /* White text for inputs */
        }
        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #0056b3; /* Darker blue on focus */
            outline: none; /* Remove outline */
        }
        button {
            width: 100%; /* Full width button */
            padding: 10px; /* Inner spacing for button */
            background-color: #007bff; /* Blue background for button */
            color: #fff; /* White text for button */
            border: none; /* Remove border */
            border-radius: 4px; /* Rounded corners for button */
            cursor: pointer; /* Pointer cursor on hover */
            font-size: 16px; /* Button font size */
        }
        button:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
    </style>
</head>
<body>
<h2>Login Form</h2>
<form action="auth.php" method="POST">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <button type="submit">Login</button>
</form>
</body>
</html>
