<?php
// Include the database connection file
require_once '../backend/conn.php';

// Handle form submission for both login and registration
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the form is for login or registration
    if (isset($_POST['login'])) {
        // Handle login
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Check if the user exists in the database
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        // Fetch the user data
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify the password
        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['username'] = $username;
            header('Location: ../index.php');
            exit();
        } else {
            $loginError = "Invalid username or password!";
        }
    } elseif (isset($_POST['register'])) {
        // Handle registration
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];

        // Check if the username already exists
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        // If the username already exists, show an error
        if ($stmt->rowCount() > 0) {
            $registerError = "Username already exists!";
        } elseif ($password !== $confirmPassword) {
            $registerError = "Passwords do not match!";
        } else {
            // Hash the password before storing it
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Insert the new user into the database
            $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
            $stmt->execute();

            // Redirect to login page after successful registration
            $registerSuccess = "Registration successful! You can now log in.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Login & Register</title>
</head>
<body>
<header>
    <h1>Website Pro</h1>
    <nav>
        <a href="login.php">Login</a>
        <a href="../index.php">Dashboard</a>
        <a href="#settings">Settings</a>
    </nav>
</header>

<!-- Login Page -->
<section id="login">
    <h2>Login</h2>
    <form action="login.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit" name="login">Login</button>
    </form>
    <?php
    if (isset($loginError)) {
        echo "<p style='color:red;'>$loginError</p>";
    }
    ?>
</section>

<!-- Registration Page -->
<section id="register">
    <h2>Register</h2>
    <form action="login.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
        <button type="submit" name="register">Register</button>
    </form>
    <?php
    if (isset($registerError)) {
        echo "<p style='color:red;'>$registerError</p>";
    } elseif (isset($registerSuccess)) {
        echo "<p style='color:green;'>$registerSuccess</p>";
    }
    ?>
</section>

</body>
</html>
