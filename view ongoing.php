<?php
include("database connection.php");
session_start();
$_SESSION['NewNotifications'] = false;
// Check if the user is logged in
if (!isset($_SESSION["username"])) 
{
    header("Location: login.php");
    exit();
}
$username = $_SESSION["username"];
$query ="
        UPDATE projects
        SET seen = 1
        WHERE seen = 0
        ";
$conn->query($query);

// Prepare the SQL query to fetch current projects for the logged-in faculty
$query = "
    SELECT 
        lt.Link_ID, 
        p.Project_Title, 
        p.Start_Date, 
        p.End_Date, 
        a.Agency_Name,
        ad.Name as Admin_Name,
        lt.Project_ID
    FROM 
        linking_table lt
    JOIN 
        projects p ON lt.Project_ID = p.Project_ID
    JOIN 
        agencies_information a ON lt.Agency_ID = a.Agency_ID
    JOIN 
        admins ad ON lt.Admin_ID = ad.Admin_ID
    JOIN 
        faculty_information fac ON lt.Faculty_ID = fac.Faculty_ID
    WHERE 
        p.Status = 'Ongoing' AND fac.Name = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

$projects = [];
while ($row = $result->fetch_assoc()) 
{
    $projects[] = $row;
}

$stmt->close();
$conn->close();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Projects</title>
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

        .container 
        {
            width: 80%;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
        }

        #projects-list ul {
            list-style-type: none;
            padding: 0;
        }

        #projects-list li {
            margin: 5px 0;
        }

        #projects-list a {
            text-decoration: none;
            color: #3498db;
        }

        #projects-list a:hover {
            text-decoration: underline;
        }

        #project-details {
            margin-top: 20px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }

        .default-message {
            font-style: italic;
            color: #777;
        }

        .section {
            border: 1px solid #ccc;
            padding: 10px;
            margin-top: 10px;
            background-color: white;
            border-radius: 10px;
        }

        .back-button {
            display: inline-block;
            margin-bottom: 10px;
            padding: 10px 15px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .back-button:hover {
            background-color: #2980b9;
        }
    </style>
    <script>
        function showDetails(link_id, title, start, end, agency, admin, project_id) {
            document.querySelector('.default-message').style.display = 'none';
            document.getElementById('project-title').textContent = title;
            document.getElementById('start-date').textContent = start;
            document.getElementById('end-date').textContent = end;
            document.getElementById('agency-name').textContent = agency;
            document.getElementById('admin-name').textContent = admin;
            document.getElementById('project_id').value = project_id;
            document.getElementById('project-details').style.display = 'block';
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Current Projects</h1>
        <a href="main menu.php" class="back-button">Back to Main Menu</a>
        <div id="projects-list" class="section">
            <?php if (empty($projects)): ?>
                <p>Pretty empty here</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($projects as $project): ?>
                        <li>
                            <a href="#" onclick="showDetails('<?php echo $project['Link_ID']; ?>', 
                                                            '<?php echo addslashes($project['Project_Title']); ?>', 
                                                            '<?php echo $project['Start_Date']; ?>', 
                                                            '<?php echo $project['End_Date']; ?>', 
                                                            '<?php echo addslashes($project['Agency_Name']); ?>',
                                                            '<?php echo addslashes($project['Admin_Name']); ?>',
                                                            '<?php echo $project['Project_ID']; ?>')">
                                                            '<?php echo htmlspecialchars($project['Project_Title']); ?>'
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
        <div id="project-details" class="section">
            <h2>Project Details</h2>
            <p class="default-message">Select a Project to see the details.</p>
            <p><strong>Project Title:</strong> <span id="project-title"></span></p>
            <p><strong>Start Date:</strong> <span id="start-date"></span></p>
            <p><strong>End Date:</strong> <span id="end-date"></span></p>
            <p><strong>Agency Name:</strong> <span id="agency-name"></span></p>
            <p><strong>Admin Name:</strong> <span id="admin-name"></span></p>
            <form action="project details.php" method="POST" id="edit-form">
                <input type="hidden" name="project_id" id="project_id">
                <button type="submit">More Details</button>
            </form>
        </div>
    </div>
</body>
</html>
