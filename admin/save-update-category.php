<?php


include '_dbconnect.php';

$post_id = $_GET['id'];

if (empty($_FILES['new-image']['name'])) {
    $new_name = $_POST['old-image'];
}else{
    $errors = array();

    $file_name = $_FILES['new-image']['name'];
    $file_type = $_FILES['new-image']['type'];
    $file_size = $_FILES['new-image']['size'];
    $file_tmp = $_FILES['new-image']['tmp_name'];
    $file_ext =  explode('.', $file_name);

    $file_ext_check = strtolower(end($file_ext));
    $extensions = array("jpeg", "jpg", "png");

    if(in_array($file_ext_check, $extensions) === false){
        $errors[] = "This extension file is not allowed, Please choose a jpg or png file.";
    }

    if($file_size > 2017592){
        $errors[] = "Your file size must be less than or equal to 2MB";
    }

    $new_name = time(). "-". basename($file_name);
    $target = "upload/" . $new_name;

    if(empty($errors) == true){
        move_uploaded_file($file_tmp, $target);
    }else{
        print_r($errors);
        die;
    }
}




$catName = mysqli_real_escape_string($conn, $_POST['catName']);
$desc = mysqli_real_escape_string($conn, $_POST['desc']);

$sql = "UPDATE `categories` SET `category_name` = '$catName', `category_description` = '$desc', `category_img` = '$new_name' WHERE category_id = $post_id";


if(mysqli_query($conn, $sql)){
    header("location: showCategory.php");
}else{
    echo "Query Failed.";
}




?>