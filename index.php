<?php
include("database connection.php");
    session_start();

if(isset($_SESSION['username'])) 
{
    // User is logged in, display the home page
    header("Location: main menu.php");
    exit();
} 
else 
{
    // User is not logged in, display the login/sign-up page
    header("Location: index no session.php");
    exit();
}
?>
