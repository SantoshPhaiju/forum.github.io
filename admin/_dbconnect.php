<?php
// session_start();

// if(!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] != true){
//     header("location: index.php");
// }

// Script to connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$database = "idiscuss";

$conn = mysqli_connect($servername, $username, $password, $database);




?>