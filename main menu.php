<?php
include("database connection.php"); // Adjust the file name if necessary
session_start();
$_SESSION['NewNotifications'] = true;
if($_SESSION["Agent"] == true)
{
    header("Location: AgencyMenu.php");
    exit();
}
// Function to check for notifications
function getNotifications($conn) 
{
    $username = $_SESSION["username"];
    $notifications = [];
    if($_SESSION['NewNotifications'])
    {
        $query = $conn->prepare("
        SELECT 
            a.Application_Title,
            p.Start_Date,
            p.Project_Title
        FROM 
            projects p
        JOIN 
            linking_table lt ON p.Project_ID = lt.Project_ID
        JOIN 
            faculty_information f ON lt.Faculty_ID = f.Faculty_ID
        JOIN 
            applications_information a ON lt.Application_ID = a.Application_ID
        WHERE 
            p.Start_Date = CURRENT_DATE() AND
            f.Name = ? AND
            p.seen = 0;
    ");

    // Bind the username parameter
    $query->bind_param('s', $username);
    $query->execute();

    // Get the result
    $result = $query->get_result();;
        if ($result->num_rows > 0) 
        {
            while ($row = $result->fetch_assoc()) 
            {
                $notifications[] = "Ayee!! \"". 
                                    htmlspecialchars($row['Application_Title']). "\"  approved as  \"" . 
                                    htmlspecialchars($row['Project_Title']). "\" ";
            }
        }
    
        return $notifications;
    }
    return $notifications;
}

$notifications = getNotifications($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // if Home button is clicked
    if (isset($_POST['Home'])) {
        header("Location: index.php");
        exit();
    }

    // if Profile button is clicked
    if (isset($_POST['Profile'])) {
        header("Location: profile.php");
        exit();
    }

    // if New Research Proposal button is clicked
    if (isset($_POST['New_Research_Proposal'])) {
        header("Location: Application Submission.php");
        exit();
    }
    
    // if View Submitted Proposals button is clicked
    if (isset($_POST['View_Submitted_Proposals'])) {
        header("Location: View Submitted Proposals.php");
        exit();
    }
    
    // Check if Current Proposals button is clicked
    if (isset($_POST['Current_Projects'])) {
        header("Location: view ongoing.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Menu</title>
    <style>
        body 
        {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-image: url('5.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            animation: backgroundAnimation 20s infinite alternate;
        }

        /*@keyframes backgroundAnimation {
            0% { filter: brightness(100%); }
            100% { filter: brightness(80%); }
        }*/

        .container 
        {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 20px;
        }

        .left-box, .right-box 
        {
            width: 30%;
            display: flex;
            flex-direction: column;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .left-box:hover, .right-box:hover 
        {
            transform: scale(1.05);
        }

        .header 
        {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: white;
            backdrop-filter: blur(5px);
        }

        .header-title 
        {
            flex-grow: 1;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #0044cc;
            letter-spacing: 2px;
        }

        .home-button, .account-button 
        {
            padding: 10px 20px;
            background-color: #0044cc;
            border: none;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .home-button:hover, .account-button:hover 
        {
            background-color: #003399;
            transform: translateY(-3px);
        }

        .home-button 
        {
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px;
            margin-right: 20px;
        }

        .account-button 
        {
            border-top-left-radius: 20px;
            border-bottom-left-radius: 20px;
            margin-left: 20px;
        }

        .rectangle 
        {
            width: 400px;
            height: 10px;
            background-color: #0044cc;
            margin: 0 20px;
        }

        .left-buttons 
        {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .left-buttons button 
        {
            background-color: white;
            border: none;
            margin: 10px;
            padding: 15px 20px;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .left-buttons button:hover 
        {
            background-color: rgba(255, 255, 255, 0.8);
            transform: translateY(-3px);
        }

        .right-links 
        {
            background-color:white;
            padding: 10px;
            border-radius: 10px;
        }

        .right-links a 
        {
            display: block;
            color: #0044cc;
            text-decoration: none;
            margin-bottom: 10px;
            font-size: 16px;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .right-links a:hover 
        {
            color: #003399;
            transform: translateX(10px);
        }

        button 
        {
            background-color: Transparent;
            background-repeat: no-repeat;
            border: none;
            cursor: pointer;
            color: black;
            font-weight: bold;
            font-size: large;
            overflow: hidden;
            outline: none;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="home-button">
            <form action="main menu.php" method="post">
                <button name="Home" style="color: white;">Home</button>
            </form>
        </div>
        <div class="header-title">Research Grant Management System Faculty Portal</div>
        <div class="account-button">
            <form action="main menu.php" method="post">
                <button name="Profile" style="color: white;">Profile</button>
            </form>
        </div>
    </div>
    <div class="container">
        <div class="left-box">
            <div class="left-buttons">
                <form action="main menu.php" method="post">
                    <button name="New_Research_Proposal">New Research Proposal</button>
                    <button name="View_Submitted_Proposals">View Submitted Proposals</button>
                    <button name="Current_Projects">Current Projects</button>
                </form>
            </div>
        </div>
        <div class="right-box">
            <div class="right-links">
                <?php if (empty($notifications)): ?>
                    <p>No new notifications</p>
                <?php else: ?>
                    <?php foreach ($notifications as $notification): ?>
                        <a href="view ongoing.php"><?php echo $notification; ?></a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
