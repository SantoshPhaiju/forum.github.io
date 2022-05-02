<?php

include '_dbconnect.php';
$id = $_GET['id'];
if(!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] != true){
    header("location: index.php");
}


$sql1 = "SELECT * FROM categories WHERE category_id = $id";
$result1 = mysqli_query($conn, $sql1) or die("Query Failed: SELECT");

$row = mysqli_fetch_assoc($result1);

unlink("upload/" . $row['category_img']);



$sql = "DELETE FROM `categories` WHERE `categories`.`category_id` = $id";
$result = mysqli_query($conn, $sql);

if($result){
    header("location: showCategory.php");
}else{
    echo "Query Failed.";
}



?>