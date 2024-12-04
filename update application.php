<?php
session_start();
include("database connection.php");

if (isset($_POST['application_id'])) {
    $application_id = $_POST['application_id'];
    $application_title = $_POST['application_title'];
    
    $status = 'Pending';
    $expected_expense = $_POST['expected_expense'];
    
    // Fetch the current file path from the database
    $query = "SELECT Details FROM applications_information WHERE Application_ID = ?";
    if ($stmt = $conn->prepare($query)) 
    {
        $stmt->bind_param('i', $application_id);    
        $stmt->execute();                           //query is executed
        $stmt->bind_result($current_file_path);     //tells that the current_file_path variable is bound to this query's execution
        $stmt->fetch();                             // stores the result from running query in a bound variable
        $stmt->close();
    }

    // Handle file upload
    if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] == 0) 
    {
        // checks if file was uploaded and if its corrupted
        $uploaded_file_path = 'details/' . basename($_FILES['pdf']['name']);
        move_uploaded_file($_FILES['pdf']['tmp_name'], $uploaded_file_path);
    } 
    else 
    {
        // means either file was corrupted or no file was uploaded... so use old one
        $uploaded_file_path = $current_file_path;
        echo "Uploadedfile is  $uploaded_file_path  successfully.";
    }

    // Update the database with the new or existing file path
    $query = "UPDATE applications_information
              SET Application_Title = ?, Status = ?, Details = ?, Expected_Expense = ?
              WHERE Application_ID = ?";
    if ($stmt = $conn->prepare($query)) 
    {
        $stmt->bind_param('sssdi', $application_title, $status, $uploaded_file_path, $expected_expense, $application_id);
        $stmt->execute();
        $stmt->close();
    }
    echo '<script>
                alert("Updated successful!");
                setTimeout(function() {
                    window.location.href = "index.php";
                }, 2000); 
                </script>';

} 
else 
{
    header("Location: index.php");
    echo "Something went wrong try again later.";
    exit();
}

$conn->close();
?>