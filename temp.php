<?php
include("database connection.php"); // Adjust the file name if necessary
session_start();
if($_SESSION["Agent"] == true)
{
    header("Location: AgencyMenu.php");
    exit();
}
// Function to check for notifications
function getNotifications($conn) 
{
    $notifications = [];
    if(($_SESSION['NewNotifications']))
    {
        $query = "
        SELECT 
        p.Project_Title,
        p.Start_Date
        FROM 
            projects p
        JOIN 
            linking_table lt ON p.Project_ID = lt.Project_ID
        JOIN 
            faculty_information f ON lt.Faculty_ID = f.Faculty_ID
        WHERE 
            p.Start_Date = CURRENT_DATE()";
    
        $result = $conn->query($query);
        if ($result->num_rows > 0) 
        {
            while ($row = $result->fetch_assoc()) 
            {
                $notifications[] = "New Approval!!! '" . 
                                    htmlspecialchars($row['Project_Title']);
            }
        }
    
        return $notifications;
    }

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
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url('6.jpg');
            background-size: cover;
            background-repeat: no-repeat;
        }

        .container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 20px;
        }

        .left-box {
            width: 30%;
            display: flex;
            flex-direction: column;
        }

        .right-box {
            width: 30%;
            display: flex;
            flex-direction: column;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.7); /* Semi-transparent white background */
            backdrop-filter: blur(5px); /* Add blur effect to background */
        }
        .home-button {
            padding: 10px 20px;
            background-color: #0044cc; /* Blue color */
            border: none;
            border-top-right-radius: 20px; /* Stylish quadrilateral shape */
            border-bottom-right-radius: 20px; /* Stylish quadrilateral shape */
            margin-right: 20px;
            color: white;
            font-weight: bold;
        }
        .account-button {
            padding: 10px 20px;
            background-color: #0044cc; /* Blue color */
            color: white;
            border: none;
            border-top-left-radius: 20px; /* Stylish quadrilateral shape */
            border-bottom-left-radius: 20px; /* Stylish quadrilateral shape */
            margin-left: 20px;
            font-weight: bold;
        }
        .rectangle {
            width: 400px;
            height: 10px; /* Adjust height as needed */
            background-color: #0044cc; /* Blue color */
            margin: 0 20px;
        }
        .left-buttons {
            display: flex;
            flex-direction: column; /*top to down*/
            margin-bottom: 20px;
        }
        .left-buttons button {
            background-color: rgba(255, 255, 255, 0.5); /* Semi-transparent white background */
            border: none;
            margin-right: 10px;
            padding: 5px 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .left-buttons button:hover {
            background-color: rgba(255, 255, 255, 0.8); /* Lighter semi-transparent white */
        }
        .right-links {
            background-color: rgba(255, 255, 255, 0.3); /* Semi-transparent white background */
            padding: 10px;
            border-radius: 10px;
        }
        .right-links a {
            display: block;
            color: #0044cc; /* Blue color */
            text-decoration: none;
            margin-bottom: 5px;
            transition: color 0.3s ease;
        }
        .right-links a:hover {
            color: #003399; /* Darker blue color */
        }
        button {
            background-color: Transparent;
            background-repeat: no-repeat;
            border: none;
            cursor: pointer;
            color: white;
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
                <button name="Home">Home</button>
            </form>
        </div>
        <div class="rectangle"></div>
        <div class="account-button">
            <form action="main menu.php" method="post">
                <button name="Profile">Profile</button>
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
                    <p> </p>
                <?php else: ?>
                    <?php foreach ($notifications as $notification): ?>
                        <a href="#"><?php echo $notification; ?></a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
