<?php

include '_dbconnect.php';
session_start();
if(!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] != true){
    header("location: index.php");
}
$showError = false;

$userid = $_GET['userid'];

$sql2 = "SELECT * FROM adminuser";
$result2 = mysqli_query($conn, $sql2);

if(mysqli_num_rows($result2) > 2){

    
    $sql = "DELETE FROM adminuser WHERE id = $userid;";
    $sql .= "DELETE FROM comments WHERE comment_by = $userid;";
    $sql .= "DELETE FROM threads WHERE thread_user_id = $userid";
    $result = mysqli_multi_query($conn, $sql);

    
if($userid == $_SESSION['userid']){
    session_unset();
    session_destroy();
    header("location: index.php");
    exit;
}

if($result){
    header("location: users.php");
}

}else{
    header("location: users.php?error=true");
}

?>