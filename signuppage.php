<?php
include("database connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Form</title>
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
        .signup-container {
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
        .signup-button {
            width: 100%;
            padding: 10px;
            background-color: #0044cc;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .signup-button:hover {
            background-color: #003399;
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <h2>Sign Up</h2>
        <form action="signuppage.php" method="post">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="input-group">
                <label for="Phone No">Phone Number</label>
                <input type="text" id="Phone" name="Phone" required>
            </div>
            <div class="input-group">
                <label for="Email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <button type="submit" class="signup-button">Sign Up</button>
        </form>
    </div>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $username = $_POST["username"];
    $password = $_POST["password"];
    $Hash = password_hash($password, PASSWORD_DEFAULT);
    $email = $_POST["email"];
    $phone = $_POST["Phone"];

    // Send data to mysql server
    $sql = "SELECT User_ID FROM logins WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 0) 
    {
        // Means username is not taken
        $sql = "INSERT INTO logins (username, password, phone, email) 
                VALUES ('$username', '$Hash', '$phone', '$email')";

        if (mysqli_query($conn, $sql)) 
        {
            echo '<script>
                alert("Registration successful!");
                setTimeout(function() {
                    window.location.href = "index.php";
                }, 2000); 
                </script>';
        } 
        else 
        {
            echo "Unexpected Error occured Please try again: ";
           // header("Location: index no session.php");
            exit();
        }
    } 
    else 
    {
        // Username already exists
        echo '<script>
            alert("Username is already taken!");
            setTimeout(function() {
                window.location.href = "signuppage.php";
            }, 2000); 
            </script>';
    }
}
?>
