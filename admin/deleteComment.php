<?php

$id = $_GET['id'];
include '_dbconnect.php';
if(!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] != true){
    header("location: index.php");
}

$sql = "DELETE FROM comments WHERE comment_id = $id";
$result = mysqli_query($conn, $sql);

if($result){
    header("location: showComments.php");
}else{
    echo "Query Failed.";
}








?>