<?php
    session_start();
    include("database connection.php");

    if (!isset($_SESSION['username'])) 
    {
        header("Location: login.php"); // Redirect to login if not logged in
        exit();
    }

    $username = $_SESSION['username'];
    // get user information from the database to display in html
    $query = "SELECT username, Phone, email FROM logins WHERE username = ?";
    if ($stmt = $conn->prepare($query)) 
    {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->bind_result($name, $phone, $email);
        $stmt->fetch();
        $stmt->close();
    } 
    else 
    {
        echo "Error preparing statement: " . $conn->error;
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout'])) 
    {
        // Logout and destroy session
        session_destroy();
        header("Location: index.php");
        exit();
    }

    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url('5.jpg');
            background-size: cover;
            background-repeat: no-repeat;
        }

        .container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 20px;
        }

        .left-box, .right-box {
            width: 30%;
            display: flex;
            flex-direction: column;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(5px);
        }
        
        .home-button, .account-button, .logout-button {
            padding: 10px 20px;
            background-color: #0044cc;
            color: white;
            border: none;
            font-weight: bold;
        }
        
        .home-button {
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px;
            margin-right: 20px;
        }
        
        .logout-button {
            border-top-left-radius: 20px;
            border-bottom-left-radius: 20px;
            margin-left: 20px;
        }

        .rectangle {
            width: 80%;
            height: 10px;
            background-color: #0044cc;
            margin: 0 20px;
        }

        .profile-info {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            color: #000;
        }
        
        button {
            background-color: Transparent;
            background-repeat:no-repeat;
            border: none;
            cursor:pointer;
            color: white;
            font-weight: bold;
            font-size: large;
            overflow: hidden;
            outline:none;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="home-button">
            <form action="main menu.php" method="post">
                <button name="Home">Home</button>
            </form>
        </div>
        <div class="rectangle"></div>
        <div>
            <form action="main menu.php" method="post">
                <input type="hidden" name="Profile">
            </form>
        </div>
        <div class="logout-button">
            <form action="profile.php" method="post">
                <button name="logout">Logout</button>
            </form>
        </div>
    </div>
    <div class="container">
        <div class="left-box">
            <div class="left-buttons">
                <form action="main menu.php" method="post">
                    <input type="hidden" name="New Research Proposal"></input>
                    <input type="hidden" name="New Research Proposal"></input>
                    <input type="hidden" name="New Research Proposal"></input>
                    
                </form>
            </div>
        </div>
        <div class="right-box">
            <div class="profile-info">
                <h2>Profile Information</h2>
                <p><strong>Username:</strong> <?php echo htmlspecialchars($name); ?></p>
                <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($phone); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            </div>
        </div>
    </div>
</body>
</html>
