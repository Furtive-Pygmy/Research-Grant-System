<?php
session_start();
include("database connection.php");

if (isset($_POST['application_id'])) 
{
    $application_id = $_POST['application_id'];
    //echo "Application ID to edit: " . htmlspecialchars($application_id);
    // Fetch application details based on application_id for editing
    $query = "
    SELECT 
        A.Application_Title,
        A.Submission_Date,
        A.Details,
        A.Expected_Expense
    FROM
        applications_information A
    WHERE
        A.Application_ID = ?
    ";

    if ($stmt = $conn->prepare($query)) 
    {
        $stmt->bind_param('i', $application_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $application = $result->fetch_assoc();
        $stmt->close();
        //echo "Application_Title: '$result[Application_Title]'";
    } 
    else 
    {
        echo "Error preparing statement: " . $conn->error;
        exit();
    }
    unset($_SESSION['application_id']);
} 
else 
{
    echo "No application ID provided.";
    exit();
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Application</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 80%;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 10px;
        }

        input, textarea {
            margin-top: 5px;
            padding: 10px;
            font-size: 1em;
        }

        button {
            margin-top: 20px;
            padding: 10px;
            font-size: 1em;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Application</h1>
        <form action="update application.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="application_id" value="<?php echo htmlspecialchars($application_id); ?>">
            <label for="application_title">
                Application Title:</label>
            <input type="text" id="application_title" name="application_title" 
                value="<?php echo htmlspecialchars($application['Application_Title']); ?>" required>
            <label for="pdf">Upload PDF:</label>
            <a href="<?php echo htmlspecialchars($application['Details']); ?>" target="_blank">View Current PDF</a>
            <input type="file" id="pdf" name="pdf" accept="application/pdf">
            <label for="expected_expense">Expected Expense:</label>
            <input type="text" id="expected_expense" name="expected_expense" value="<?php echo htmlspecialchars($application['Expected_Expense']); ?>" required>
            <button type="submit">Update Application</button>
        </form>
    </div>
</body>
</html>
