
<!DOCTYPE html>
<html>
<?php
session_start();
include 'script.php';

if(isset($_SESSION["user"]))  
{ 
    if((time() - $_SESSION["login_time_stamp"]) > 300) // The session time is 5 minutes.   
    { 
        session_unset(); 
        session_destroy(); 
    } 
} 

?>
    <head>
        <meta charset="UTF-8">
        <title>Test API</title>
        <h1> THE TEST MANAGEMENT SERVICE </h1>
    </head>
<body style="background-color:#CAD9D9; font-family:'verdana';">

Welcome to our product listing database. You can find whatever you are looking for from this webpage. We hope you enjoy!
<div>
<button onclick="location.href='/jackets.php'">Jackets</button><br>
<button onclick="location.href='/shirts.php'">Shirts</button><br>
<button onclick="location.href='/accessories.php'">Accessories</button>
</div>

