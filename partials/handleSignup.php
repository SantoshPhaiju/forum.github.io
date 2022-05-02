<?php


    include '_dbconnect.php';

    
    
    if(isset($_FILES['userImg'])){
        $errors = array();

        $file_name = $_FILES['userImg']['name'];
        $file_type = $_FILES['userImg']['type'];
        $file_size = $_FILES['userImg']['size'];
        $file_tmp = $_FILES['userImg']['tmp_name'];
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
        $target = "/forum/admin/upload/" . $new_name;

        if(empty($errors) == true){
            move_uploaded_file($file_tmp, $target);
        }else{
            print_r($errors);
            die;
        }
    }

    
    $file_name = $_FILES['userImg']['name'];
    $new_name = time(). "-". basename($file_name);
        
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, md5($_POST['pass']));
        $role =  $_POST['role'];
        
        $sql = "INSERT INTO `adminuser` (`name`, `username`, `email`, `password`, `role`, `user_image`) VALUES ('$name', '$username', '$email', '$password', '$role', '$new_name')";
        
        

    if(mysqli_query($conn, $sql)){
        header("location: /forum/index.php");
 }else{
        echo "Query Failed:";
}











?>