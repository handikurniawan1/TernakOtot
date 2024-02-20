<?php
session_start();

require_once ('../php/CreateDb.php');

// Create instance of CreateDb class
$database = new CreateDb("Gymdb", "user");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emailOrUsername = $_POST["email_or_username"];
    $password = $_POST["password"];

    // Check if emailOrUsername contains "@". If yes, treat it as email, otherwise treat it as username
    if (strpos($emailOrUsername, "@") !== false) {
        // Login using email
        $field = "email";
        $value = $emailOrUsername;
    } else {
        // Login using username
        $field = "username";
        $value = $emailOrUsername;
    }

    // Validate email or username
    if ($field === "email" && !validateEmail($value)) {
        echo '<script>alert("Invalid email address.");</script>';
    } else {
        // Check if email or username and password match in the database
        $result = $database->getData();
        $userFound = false;
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row[$field] == $value && $row['password'] == $password) {
                $userFound = true;
                // Set session variable 'user'
                $_SESSION['user'] = $row['username']; // Simpan username ke dalam session user
                // Show success message
                echo '<script>alert("Login Succesfull");</script>';

                // Redirect to login page after a delay
                echo '<script>setTimeout(function() { window.location.href = "home.php"; }, 500);</script>';
            }
        }

        // If email or username and password do not match, show error message
        if (!$userFound) {
            echo '<script>alert("Invalid username or password.");</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/login.css">
    <title>Login</title>
</head>
<body class="center-container">
    <form class="form" method="POST">
        <p class="title">LOGIN</p>
        <p class="message">Login now and get full access to our app. </p>        
        <label>
            <input required="" placeholder="" type="text" name="email_or_username" class="input">
            <span>Email or Username</span>
        </label> 
            
        <label>
            <input required="" placeholder="" type="password" name="password" class="input">
            <span>Password</span>
        </label>
        <button type="submit" class="submit">Login</button>
        <p class="signin">Don't have an account? <a href="Signup.php">Sign up</a> </p>
    </form>
</body>
</html>
