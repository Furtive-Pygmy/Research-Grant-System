<?php
session_start();
include("database connection.php");

//will store applications
$applications = [];
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $query = "
    SELECT 
        L.Application_ID,
        A.Application_Title,
        A.Submission_Date,
        A.Details,
        A.Expected_Expense
    FROM
        linking_table L
            INNER JOIN
        faculty_information F ON L.Faculty_ID = F.Faculty_ID
            INNER JOIN
        applications_information A ON L.Application_ID = A.Application_ID
        WHERE
        L.GrantedRequest_ID IS NULL";

    if ($stmt = $conn->prepare($query)) 
    {
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) 
        {
            $applications[] = $row;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
} 
else 
{
    echo "User not logged in.";
    exit();
}
$conn->close();
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Applications</title>
    <style>
        body 
        {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('6.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-color: #f0f8ff;
            font-family: Arial, sans-serif;
            margin: 0;
        }

        .container
        {
            width: 80%;
            margin: 0 auto;
        }

        h1 
        {
            text-align: center;
        }

        #projects-list ul 
        {
            list-style-type: none;
            padding: 0;
        }

        #projects-list li 
        {
            margin: 5px 0;
        }

        #projects-list a 
        {
            text-decoration: none;
            color: #3498db;
        }

        #projects-list a:hover 
        {
            text-decoration: underline;
        }

        #project-details 
        {
            margin-top: 20px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }

        .default-message 
        {
            font-style: italic;
            color: #777;
        }

        .section 
        {
            border: 1px solid #ccc;
            padding: 10px;
            margin-top: 10px;
            background-color: white;
            border-radius: 10px;
        }

        .back-button 
        {
            display: inline-block;
            margin-bottom: 10px;
            padding: 10px 15px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .back-button:hover 
        {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Viewing Pending Applications</h1>
        <a href="main menu.php" class="back-button">Back to Main Menu</a>
        <div id="applications-list" class="section">
            <?php if (empty($applications)): ?>
                <p>Pretty empty here</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($applications as $application): ?>
                        <li>
                            <a href="#" onclick="showDetails('<?php echo $application['Application_ID']; ?>', 
                                                            '<?php echo addslashes($application['Application_Title']); ?>', 
                                                            '<?php echo $application['Submission_Date']; ?>', 
                                                            '<?php echo addslashes($application['Details']); ?>', 
                                                            '<?php echo $application['Expected_Expense']; ?>')">
                                <?php echo htmlspecialchars($application['Application_Title']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
        <div id="application-details" class="section">
            <h2>Application Details</h2>
            <p class="default-message">Select an application to see the details.</p>
            <p><strong>Application Title:</strong> <span id="application-title"></span></p>
            <p><strong>Submission Date:</strong> <span id="submission-date"></span></p>
            <p><strong>Details:</strong> <a id="details-link" href="#" target="_blank">Open Document</a></p>
            <p><strong>Expected Expense:</strong> <span id="expected-expense"></span></p>
            <form action="Sponser application.php" method="get" id="edit-form">
                <input type="hidden" name="application_id" id="application_id">
                <button type="submit">   Sponser  </button>
            </form>
        </div>
    </div>

    <script>
    function showDetails(id, title, date, details, expense) {
        document.querySelector('.default-message').style.display = 'none';
        document.getElementById('application-title').textContent = title;
        document.getElementById('submission-date').textContent = date;
        document.getElementById('details-link').href = details;
        document.getElementById('expected-expense').textContent = expense;
        document.getElementById('application_id').value = id;
        document.getElementById('application-details').style.display = 'block';
    }
    </script>
</body>
</html>