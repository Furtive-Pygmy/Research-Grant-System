<?php
include("database connection.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    // Initialize variables
    $application_id = $_POST['application_id'];
    $project_title = isset($_POST['project_title']) ? $conn->real_escape_string($_POST['project_title']) : '';
    $agency_name = $_SESSION['username'];
    $contact_number = isset($_POST['phone']) ? $conn->real_escape_string($_POST['phone']) : '';
    $spokesman = isset($_POST['spokesman']) ? $conn->real_escape_string($_POST['spokesman']) : '';
    $admin_name = isset($_POST['admin_name']) ? $conn->real_escape_string($_POST['admin_name']) : '';
    $admin_phone = isset($_POST['admin_phone']) ? $conn->real_escape_string($_POST['admin_phone']) : '';
    $admin_email = isset($_POST['admin_email']) ? $conn->real_escape_string($_POST['admin_email']) : '';
    $department = isset($_POST['department']) ? $conn->real_escape_string($_POST['department']) : '';
    //$project_id = isset($_POST['project_id']) ? $conn->real_escape_string($_POST['project_id']) : '';

    if (empty($agency_name) || empty($contact_number) || empty($spokesman) || empty($admin_name) || empty($admin_phone) || empty($admin_email) || empty($department) ) {
        echo "All fields are required.";
        exit;
    }

    // Check if the file is received and upload it
    $uploaded_file_path = '';
    if (isset($_FILES['pdf-file']) && $_FILES['pdf-file']['error'] == 0) 
    {
        $upload_dir = 'grants/';
        $uploaded_file_path = $upload_dir . basename($_FILES['pdf-file']['name']);
        if (move_uploaded_file($_FILES['pdf-file']['tmp_name'], $uploaded_file_path)) 
        {
            echo "File uploaded successfully.";
        } 
        else 
        {
            echo "Error occurred while uploading the file.";
            exit();
        }
    } 
    else 
    {
        echo "No file uploaded or an error occurred.";
        exit;
    }


    // Check if the agency already exists
    $sql_check_agency = "SELECT Agency_ID FROM agencies_information WHERE Agency_Name = '$agency_name' AND Contact = '$contact_number' AND Spokesman = '$spokesman'";
    $result_check_agency = $conn->query($sql_check_agency);

    if ($result_check_agency->num_rows > 0) {
        $row = $result_check_agency->fetch_assoc();
        $agency_id = $row['Agency_ID'];
    } 
    else 
    {
        $sql_agency_info = "INSERT INTO agencies_information (Agency_Name, Contact, Spokesman)
                            VALUES ('$agency_name', '$contact_number', '$spokesman')";

        if ($conn->query($sql_agency_info) === TRUE) 
        {
            $agency_id = $conn->insert_id;
        } 
        else 
        {
            echo "Error: " . $sql_agency_info . "<br>" . $conn->error;
            exit;
        }
    }

    // Insert data into Granted_Requests
    $sql_granted_requests = "INSERT INTO granted_requests (Resources_Granted, Start_Date, Expiry_Date)
                             VALUES ('$uploaded_file_path', CURRENT_DATE(), DATE_ADD(CURRENT_DATE(), INTERVAL 1 YEAR))";

    if ($conn->query($sql_granted_requests) === TRUE) 
    {
        $granted_request_id = $conn->insert_id;
    } 
    else 
    {
        echo "Error: " . $sql_granted_requests . "<br>" . $conn->error;
        exit;
    }

    // Insert data into Projects
    $sql_projects = "INSERT INTO projects (Project_Title, Start_Date, End_Date)
                     VALUES ('$project_title', CURRENT_DATE(), DATE_ADD(CURRENT_DATE(), INTERVAL 1 YEAR))";

    if ($conn->query($sql_projects) === TRUE) 
    {
        $project_id = $conn->insert_id;
    } 
    else 
    {
        echo "Error: " . $sql_projects . "<br>" . $conn->error;
        exit;
    }

    // Insert data into Admins
    $sql_admins = "INSERT INTO admins (Name, Phone_Number, email, Department)
                   VALUES ('$admin_name', '$admin_phone', '$admin_email', '$department')";

    if ($conn->query($sql_admins) === TRUE) 
    {
        $admin_id = $conn->insert_id;
    } 
    else 
    {
        echo "Error: " . $sql_admins . "<br>" . $conn->error;
        exit;
    }

    // Update Linking Table
    $sql_linking_table = "UPDATE linking_table SET Agency_ID = '$agency_id', Project_ID = '$project_id', GrantedRequest_ID = '$granted_request_id', Admin_ID = '$admin_id' WHERE Application_ID = '$application_id'";

    if ($conn->query($sql_linking_table) === TRUE) 
    {
        echo '<script>
                alert("Sponsorship successful!");
                setTimeout(function() 
                {
                    window.location.href = "AgencyMenu.php";
                }, 2000); 
                </script>';
    } 
    else 
    {
        echo "Error updating linking_table: " . $conn->error;
    }


}
?>
