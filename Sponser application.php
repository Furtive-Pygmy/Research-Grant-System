<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sponsorship Application</title>
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
        }
        .container 
        {
            background-color: white;
            padding: 20px 40px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 
        {
            color: #0044cc;
        }
        .form-group 
        {
            margin-bottom: 20px;
        }
        label 
        {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input 
        {
            width: 100%;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        .buttons button 
        {
            padding: 10px 20px;
            background-color: #0044cc;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin: 0 10px;
        }
        .buttons button:hover 
        {
            background-color: #003399;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Sponsorship Application</h1>
        <form id="upload-form" action="Sponser application2.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="pdf-file">Upload PDF with Terms and Grants:</label>
                <input type="file" name="pdf-file" id="pdf-file" accept="application/pdf" required>
            </div>
            <div class="form-group">
                <label for="name">Agency Name:</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="phone">Contact Number:</label>
                <input type="text" name="phone" id="phone" required>
            </div>
            <div class="form-group">
                <label for="spokesman">Agency Spokesman:</label>
                <input type="text" name="spokesman" id="spokesman" required>
            </div>
            <div class="form-group">
                <label for="admin-name">Admin Name:</label>
                <input type="text" name="admin_name" id="admin-name" required>
            </div>
            <div class="form-group">
                <label for="admin-phone">Admin Contact Number:</label>
                <input type="text" name="admin_phone" id="admin-phone" required>
            </div>
            <div class="form-group">
                <label for="admin-email">Admin Email:</label>
                <input type="email" name="admin_email" id="admin-email" required>
            </div>
            <div class="form-group">
                <label for="department">Admin Department:</label>
                <input type="text" name="department" id="department" required>
            </div>
            <div class="form-group">
                <label for="project-title">Project Title:</label>
                <input type="text" name="project_title" id="project-title" required>
            </div>
            <input type="hidden" name="application_id" id="application-id" value="<?php echo $_GET['application_id']; ?>">
            <div class="buttons">
                <button type="submit">Submit</button>
            </div>
        </form>
    </div>
</body>
</html>
