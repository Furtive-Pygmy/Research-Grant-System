<?php
session_start();

if (isset($_POST['application_id'])) 
{
    $_SESSION['current_application_id'] = $_POST['application_id'];
    echo "Session updated.";
} else {
    echo "No application ID provided.";
}
?>
