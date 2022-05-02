<?php 



if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST"){
    
    
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
        $target = "upload/" . $new_name;

        if(empty($errors) == true){
            move_uploaded_file($file_tmp, $target);
        }else{
            print_r($errors);
            die;
        }

    
    }




    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['pass']));
    $role =  $_POST['role'];

    $sql = "INSERT INTO `adminuser` (`name`, `username`, `email`, `password`, `role`, `user_image`) VALUES ('$name', '$username', '$email', '$password', '$role', '$new_name')";

    if(mysqli_query($conn, $sql)){
        header("location: users.php");
 }else{
        echo "Query Failed:";
}




}



?>









<?php

include '_header.php';
if(!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] != true){
    header("location: index.php");
}
?>
<style>
    .userForm {
        width: 80%;
        margin: 0 auto;
    }

    .col-md-offset-3 {
        margin: 0 auto;
    }
</style>

<div id="admin-content">

    <div class="container my-5">
        <div class="row">
            <div class="col-md-offset-3 col-md-8">
               
                <h1 class="heading">Add new user:</h1>
                    
                <form class="my-3 userForm" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                    <div class="form-group my-2">
                        <label for="name">Name:</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Name" required>
                    </div>
                    <div class="form-group my-2">
                        <label for="username">Username:</label>
                        <input type="text" name="username" placeholder="Username" id="username" class="form-control" required>
                    </div>
                    <div class="form-group my-2">
                        <label for="email">Email:</label>
                        <input type="email" name="email" placeholder="abc@gmail.com" class="form-control" id="email" required>
                    </div>
                    <div class="form-group my-2">
                        <label for="pass">Password:</label>
                        <input type="password" placeholder="password" name="pass" class="form-control" id="pass" required>
                    </div>
                    <div class="form-group my-2">
                        <label>Role:</label>
                        <select class="form-select" name="role" id="role">
                            <option value="1" selected>Admin</option>
                            <option value="0">Normal User</option>

                        </select>
                    </div>
                    <div class="form-group my-2">
                        <label for="userImg" class="my-1">User Image</label><br>
                        <input type="file" name="userImg" id="UserImg" required>
                    </div>
                    <input type="submit" name="submit" class="btn btn-primary" value="Add user" />
                </form>

            </div>
        </div>
    </div>



</div>

</div>


<?php
include '_footer.php';

?>