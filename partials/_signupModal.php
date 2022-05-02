
<?php

if($_SERVER['REQUEST_METHOD'] == "POST"){
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
            $target = "admin/upload/" . $new_name;
            
            if(empty($errors) == true){
                move_uploaded_file($file_tmp, $target);
            }else{
            print_r($errors);
            die;
        }

        
        
        
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, md5($_POST['pass']));
        $role =  $_POST['role'];
        $token = bin2hex(random_bytes(15));


        $existSql = "SELECT * FROM `adminuser` WHERE email = '$email'";
        $result = mysqli_query($conn, $existSql) or die("Query Failed.");
        $existRows = mysqli_num_rows($result);
    
        if($existRows > 0){
            echo "<p style='color: red; text-align: center; margin: 10px 0px;'>Email already exists</p>";
        }else{
            $sql = "INSERT INTO `adminuser` (`name`, `username`, `email`, `password`, `role`, `token`, `user_image`) VALUES ('$name', '$username', '$email', '$password', '$role', '$token', '$new_name')";
            
            $result = mysqli_query($conn, $sql);
            // session_start();
            if($result){
                $_SESSION['signedup'] = "<p style='color: red; text-align: center; margin: 10px 0px;'>You are signedup. Now you can processed through login.</p>";
            }else{
                echo "Query Failed.";
            }
        }
        
    }
}

?>


<div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="signupModalLabel">Signup for an iDiscuss account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
             
            <form action"<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
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
                        <label for="UserImg" class="my-1">User Image</label><br>
                        <input type="file" name="userImg" id="UserImg" required>
                    </div>
                    <input type="hidden" name="role" value="0">
                    <button type="submit" class="btn btn-primary">Signup</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>


        </div>
    </div>
</div>


