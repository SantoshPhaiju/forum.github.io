<?php

$id = $_GET['id'];
include '_dbconnect.php';
if(!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] != true){
    header("location: index.php");
}

$sql = "DELETE FROM threads WHERE thread_id = $id";
$result = mysqli_query($conn, $sql);

if($result){
    header("location: showThreads.php");
}else{
    echo "Query Failed.";
}








?>