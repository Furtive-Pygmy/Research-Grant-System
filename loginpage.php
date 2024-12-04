<?php
include("database connection.php");
session_start();
$_SESSION["Agent"] = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $username = $_POST["username"];
    $password = $_POST["password"];
    $_SESSION['NewNotifications'] = true;

    // Running query to check if the username exists
    $sql = "SELECT * FROM logins WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // User found, now verify the password
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) 
        {
            // Password is correct, start the session
            $_SESSION['username'] = $username;
            $_SESSION['Phone'] = $user['phone'];
            $_SESSION['Email'] = $user['email'];
            $Agent = $user['Agency'];

            if ($Agent) 
            { 
                $_SESSION["Agent"] = true;
                header("Location: AgencyMenu.php");
                exit();
            } 
            else 
            {
                header("Location: index.php");
                exit();
            }
        } 
        else 
        {
            // Incorrect password
            echo "Invalid username or password.";
        }
    } 
    else 
    {
        // User not found
        echo "Invalid username or password.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f8ff;
            font-family: Arial, sans-serif;
        }
        .login-container {
            background-color: white;
            padding: 20px 40px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #0044cc;
        }
        .input-group {
            margin-bottom: 15px;
        }
        .input-group label {
            display: block;
            color: #0044cc;
            margin-bottom: 5px;
        }
        .input-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #0044cc;
            border-radius: 4px;
        }
        .login-button {
            width: 100%;
            padding: 10px;
            background-color: #0044cc;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .login-button:hover {
            background-color: #003399;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="loginpage.php" method="post">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="login-button">Login</button>
        </form>
    </div>
</body>
</html>
