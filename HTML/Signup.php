<?php
session_start();

require_once ('../php/CreateLog.php');

// Create instance of CreateDb class
$database = new CreateDb("Gymdb", "user");



// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];

    // Check if username or email already exists
    $result = $database->getData();
    $usernameExists = false;
    $emailExists = false;
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['username'] == $username) {
            $usernameExists = true;
        }
        if ($row['email'] == $email) {
            $emailExists = true;
        }
    }

    // If username or email already exists, show error message
    if ($usernameExists) {
        echo '<script>alert("Username already exists.");</script>';
    }
    if ($emailExists) {
        echo '<script>alert("Email already exists.");</script>';
    }

    // If no error, insert data into database
    if (!$usernameExists && !$emailExists) {
        $database->insertData($username, $email, $password);

        // Show success message
        echo '<script>alert("Registration successful. Please login.");</script>';

        // Redirect to login page after a delay
        echo '<script>setTimeout(function() { window.location.href = "Login.php"; }, 500);</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/signup.css">
    <style>
        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }
    </style>
    <title>Signup</title>
</head>
<body class="center-container">
    <form class="form" method="POST" onsubmit="return validateForm()">
        <p class="title">REGISTER</p>
        <p class="message">Signup now and get full access to our app. </p>
        <label>
            <input required="" placeholder="" type="text" name="username" id="username" class="input" pattern=".{8,}" title="Username should be at least 8 characters long.">
            <span>Username</span>
            <div class="error-message" id="username-error"></div>
        </label>
        <label>
            <input required="" placeholder="" type="email" name="email" id="email" class="input" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" title="Invalid email address.">
            <span>Email</span>
            <div class="error-message" id="email-error"></div>
        </label>
        <label>
            <input required="" placeholder="" type="password" name="password" id="password" class="input" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Password should be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one digit.">
            <span>Password</span>
        </label>
        <label>
            <input required="" placeholder="" type="password" name="confirm_password" id="confirm_password" class="input" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Password should be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one digit.">
            <span>Confirm password</span>
            <div class="error-message" id="password-error"></div>
        </label>
        <button type="submit" class="submit">Sign up</button>
        <p class="signin">Already have an account? <a href="Login.php">Sign in</a></p>
    </form>

    <script>
        function validateForm() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm_password").value;
            var passwordError = document.getElementById("password-error");

            passwordError.innerText = "";

            // Validate password
            if (password !== confirmPassword) {
                passwordError.innerText = "Passwords do not match.";
                return false;
            }

            return true;
        }
    </script>
</body>
</html>


