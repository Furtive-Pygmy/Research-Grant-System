<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Welcome</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f0f8ff;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }
            .welcome-container {
                background-color: white;
                padding: 20px 40px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                text-align: center;
            }
            .welcome-container a {
                display: block;
                margin: 10px 0;
                padding: 10px;
                background-color: #0044cc;
                color: white;
                text-decoration: none;
                border-radius: 4px;
                font-size: 16px;
            }
            .welcome-container a:hover {
                background-color: #003399;
            }
        </style>
    </head>
    <body>
        <div class="welcome-container">
            <h2>Welcome</h2>
            <a href="loginpage.php">Login</a>
            <a href="signuppage.php">Sign Up</a>
        </div>
    </body>
    </html>';