<?php
include("database connection.php");
// ensuring the project id was recieved
$project_id = isset($_POST['project_id']) ? (int)$_POST['project_id'] : 0;

if ($project_id <= 0) 
{
    echo "Invalid Project ID.";
    exit();
}

// get all project details including PDF file paths and additional information
$query = "
    SELECT 
        p.Project_Title, 
        p.Start_Date, 
        p.End_Date, 
        p.Status,
        a.Agency_Name,
        a.Contact as Agency_Contact,
        a.Spokesman as Agency_Spokesman,
        ad.Name as Admin_Name,
        ad.Phone_Number as Admin_Phone,
        ad.email as Admin_Email,
        gr.Resources_Granted,
        gr.Start_Date as Grant_Start_Date,
        gr.Expiry_Date as Grant_Expiry_Date
    FROM 
        linking_table lt
    JOIN 
        projects p ON lt.Project_ID = p.Project_ID
    JOIN 
        agencies_information a ON lt.Agency_ID = a.Agency_ID
    JOIN 
        admins ad ON lt.Admin_ID = ad.Admin_ID
    LEFT JOIN 
        granted_Requests gr ON lt.GrantedRequest_ID = gr.Grant_ID
    WHERE 
        lt.Project_ID = ?
";

$stmt = $conn->prepare($query);         
$stmt->bind_param("i", $project_id);            //loadign parameters
$stmt->execute();                               //checks
$result = $stmt->get_result();                  //runs and saves row
$project_details = $result->fetch_assoc();      //get the whole row in an array

if (!$project_details) 
{
    echo "Project not found.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Details</title>
    <style>
        body 
        {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f8ff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1, h2 {
            text-align: center;
        }

        .section {
            margin-top: 20px;
        }

        .section p {
            margin: 5px 0;
        }

        .back-button {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #3498db;
            border: 1px solid #3498db;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .back-button:hover {
            background-color: #3498db;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Project Details</h1>
        <div class="section">
            <h2>Project Information</h2>
            <p><strong>Project Title:</strong> <?php echo htmlspecialchars($project_details['Project_Title']); ?></p>
            <p><strong>Start Date:</strong> <?php echo htmlspecialchars($project_details['Start_Date']); ?></p>
            <p><strong>End Date:</strong> <?php echo htmlspecialchars($project_details['End_Date']); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($project_details['Status']); ?></p>
        </div>
        <div class="section">
            <h2>Agency Information</h2>
            <p><strong>Agency Name:</strong> <?php echo htmlspecialchars($project_details['Agency_Name']); ?></p>
            <p><strong>Contact:</strong> <?php echo htmlspecialchars($project_details['Agency_Contact']); ?></p>
            <p><strong>Spokesman:</strong> <?php echo htmlspecialchars($project_details['Agency_Spokesman']); ?></p>
        </div>
        <div class="section">
            <h2>Admin Information</h2>
            <p><strong>Admin Name:</strong> <?php echo htmlspecialchars($project_details['Admin_Name']); ?></p>
            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($project_details['Admin_Phone']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($project_details['Admin_Email']); ?></p>
        </div>
        <div class="section">
            <h2>Granted Request Information</h2>
            <p><strong>Resources Granted:</strong> 
                <?php 
                if ($project_details['Resources_Granted']) {
                    echo '<a href="' . htmlspecialchars($project_details['Resources_Granted']) . '" target="_blank">View PDF</a>';
                } else {
                    echo 'N/A';
                }
                ?>
            </p>
            <p><strong>Grant Start Date:</strong> <?php echo htmlspecialchars($project_details['Grant_Start_Date']); ?></p>
            <p><strong>Grant Expiry Date:</strong> <?php echo htmlspecialchars($project_details['Grant_Expiry_Date']); ?></p>
        </div>
        <a href="View Sponsored Proposals.php" class="back-button">Back to Projects</a>
    </div>
</body>
</html>