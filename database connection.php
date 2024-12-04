<?php
$servername = "127.0.0.1";
$database = "research_grant_database";
$username = "root";
$password = "";
// Check connection
$conn;
try
{
    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $database);
}
catch(mysqli_sql_exception)
{
    //echo"server connection not established";
}
?>