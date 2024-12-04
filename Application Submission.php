<?php
include("database connection.php");
session_start();

// if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $department = $_POST['department'];
    $title = $_POST['title'];
    $expense = $_POST['expense'];

    // file upload
    if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] == 0) 
    {
        $pdf = $_FILES['pdf'];
        $pdf_path = 'details/' . basename($pdf['name']);

        // save the uploaded file to the desired directory
        if (move_uploaded_file($pdf['tmp_name'], $pdf_path)) 
        {
            // adding data into the database
            $sql = "INSERT INTO applications_information (Application_Title, Submission_Date, Details, Expected_Expense) 
                    VALUES ('$title', CURRENT_DATE(), '$pdf_path', $expense)";
        
            if (mysqli_query($conn, $sql)) 
            {
                // Define the username variable from session
                $username = $_SESSION['username'];
                
                // Check if this is first time application submitted
                $sql = "SELECT Faculty_ID FROM faculty_information WHERE Name = '$username'";
                $result = mysqli_query($conn, $sql);    //gives row of that user or no rows if user was not registered

                if (mysqli_num_rows($result) == 0) 
                {
                    // Means user was not in faculty_information table
                    // adding user to the table
                    $sql = "INSERT INTO faculty_information (Name, Department, Phone, email) VALUES
                            ('" . $_SESSION['username'] . "', '$department', '" . $_SESSION['Phone'] . "', '" . $_SESSION['Email'] . "')";
                    if (!mysqli_query($conn, $sql)) 
                    {
                        // Handle exception if faculty_information insertion fails
                        echo "Error: " . mysqli_error($conn);
                        exit();
                    }
                    
                    // Now getting the ID the user was added to for later
                    $sql = "SELECT Faculty_ID FROM faculty_information WHERE Name = '$username'";
                    $result = mysqli_query($conn, $sql);
                }

                $faculty_row = mysqli_fetch_assoc($result);
                $faculty_id = $faculty_row['Faculty_ID'];

                // Getting current application id
                $sql = "SELECT Application_ID FROM applications_information WHERE Application_Title = '$title'";
                if (!($app_result = mysqli_query($conn, $sql))) 
                {
                    echo "Error: " . mysqli_error($conn);
                    exit();
                }
                $app_row = mysqli_fetch_assoc($app_result);
                $app_id = $app_row['Application_ID'];

                // Adding faculty id and application id into Linking Table
                $sql = "INSERT INTO linking_table (Faculty_ID, Application_ID, Agency_ID, Project_ID, GrantedRequest_ID, Admin_ID) VALUES
                        ($faculty_id, $app_id, null, null, null, null)"; 
                if (!mysqli_query($conn, $sql)) {
                    // Handle exception if linking_table insertion fails
                    echo "Error: " . mysqli_error($conn);
                    exit();
                }
                header("Location: main menu.php");
                exit();
            } 
            else 
            {
                // Handle exception if applications_information insertion fails
                echo "Error: " . mysqli_error($conn);
                exit();
            }      
        } 
        else 
        {
            // Handle exception if file upload fails
            header("Location: Application Submission.php");
            exit();
        }
    } 
    else 
    {
        // Handle exception if file upload fails
        header("Location: Application Submission.php");
        exit();
    }
}
?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Form</title>
    <style>
        body {
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
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .form-step {
            display: none;
        }
        .form-step.active {
            display: block;
        }
        .form-navigation {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .form-navigation button {
            padding: 10px 20px;
            background-color: #0044cc;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        .form-navigation button:hover {
            background-color: #003399;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Application Form</h2>
        <form id="applicationForm" action="Application Submission.php" method="post" enctype="multipart/form-data">
            <div class="form-step active">
                <label for="department">Department:</label>
                <input type="text" id="department" name="department" required><br><br>
            </div>
            <div class="form-step">
                <label for="title">Application Title:</label>
                <input type="text" id="title" name="title" required><br><br>
            </div>
            <div class="form-step">
                <label for="pdf">Upload PDF:</label>
                <input type="file" id="pdf" name="pdf" accept="application/pdf" required><br><br>
            </div>
            <div class="form-step">
                <label for="expense">Expected Expense:</label>
                <input type="number" id="expense" name="expense" required><br><br>
            </div>
            <div class="form-navigation">
                <button type="button" id="prevBtn" onclick="nextPrev(-1)">Back</button>
                <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                <input type="submit" id="submitBtn" value="Submit" style="display: none;">
            </div>
        </form>
    </div>

    <script>
        let currentStep = 0;
        const steps = document.querySelectorAll(".form-step");
        const prevBtn = document.getElementById("prevBtn");
        const nextBtn = document.getElementById("nextBtn");
        const submitBtn = document.getElementById("submitBtn");

        function showStep(step) {
            steps.forEach((el, index) => {
                el.classList.remove("active");
                if (index === step) {
                    el.classList.add("active");
                }
            });
            prevBtn.style.display = step === 0 ? "none" : "inline";
            nextBtn.style.display = step === steps.length - 1 ? "none" : "inline";
            submitBtn.style.display = step === steps.length - 1 ? "inline" : "none";
        }

        function nextPrev(n) {
            currentStep += n;
            if (currentStep < 0) {
                currentStep = 0;
            }
            if (currentStep >= steps.length) {
                currentStep = steps.length - 1;
            }
            showStep(currentStep);
        }

        showStep(currentStep);
    </script>
</body>
</html>


