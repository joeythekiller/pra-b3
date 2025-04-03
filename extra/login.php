<?php
require_once '../backend/conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['username'] = $username;
            header('Location: ../index.php');
            exit();
        } else {
            $loginError = "Invalid username or password!";
        }
    } elseif (isset($_POST['register'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];

        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $registerError = "Username already exists!";
        } elseif ($password !== $confirmPassword) {
            $registerError = "Passwords do not match!";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
            $stmt->execute();

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
<center>
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
</center>

</body>
</html>