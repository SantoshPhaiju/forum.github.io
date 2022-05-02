<?php

$userid = $_GET['userid'];
if(!isset($_COOKIE['name']) && $_COOKIE['name'] != true){
    header("location: /forum/index.php");
 }

include '_dbconnect.php';
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST") {


    if (empty($_FILES['new-image']['name'])) {
        $new_name = $_POST['old-image'];
    } else {
        $errors = array();

        $file_name = $_FILES['new-image']['name'];
        $file_type = $_FILES['new-image']['type'];
        $file_size = $_FILES['new-image']['size'];
        $file_tmp = $_FILES['new-image']['tmp_name'];
        $file_ext =  explode('.', $file_name);

        $file_ext_check = strtolower(end($file_ext));
        $extensions = array("jpeg", "jpg", "png");

        if (in_array($file_ext_check, $extensions) === false) {
            $errors[] = "This extension file is not allowed, Please choose a jpg or png file.";
        }

        if ($file_size > 2017592) {
            $errors[] = "Your file size must be less than or equal to 2MB";
        }

        $new_name = time() . "-" . basename($file_name);
        $target = "upload/" . $new_name;

        if (empty($errors) == true) {
            move_uploaded_file($file_tmp, $target);
        } else {
            print_r($errors);
            die;
        }
    }





    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role =  $_POST['role'];

    $sql = "UPDATE adminuser SET `name` = '$name', `username` = '$username', `email` = '$email', `role` = '$role', `user_image` = '$new_name' WHERE id = $userid";

    $old_name = $_POST['old-image'];
    if (mysqli_query($conn, $sql)) {
        if(!empty($_FILES['new-image']['name'])){
            unlink("upload/".$old_name);
        }
        header("location: users.php");
    } else {
        echo "Query Failed:";
    }
}


?>

<?php

include '_header.php';
if(!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] != true){
    header("location: index.php");
}
if ($_SESSION['userid'] != $_GET['userid']) {
    $id = $_SESSION['userid'];
    header("location: updateUser.php?userid=$id");
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
                <h1 class="heading">Update user:</h1>

                <?php
                $userid = $_GET['userid'];

                $sql1 = "SELECT * FROM `adminuser` WHERE id = $userid";
                $result1 = mysqli_query($conn, $sql1);

                if (mysqli_num_rows($result1) > 0) {
                    $row = mysqli_fetch_assoc($result1);



                ?>




                        <form class="my-3 userForm" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                            <div class="form-group my-2">
                                <label for="name">Name:</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="<?php echo $row['name'] ?>" required>
                            </div>
                            <div class="form-group my-2">
                                <label for="username">Username:</label>
                                <input type="text" name="username" placeholder="Username" id="username" class="form-control" value="<?php echo $row['username'] ?>" required>
                            </div>
                            <div class="form-group my-2">
                                <label for="email">Email:</label>
                                <input type="email" name="email" placeholder="abc@gmail.com" class="form-control" id="email" value="<?php echo $row['email'] ?>" required>
                            </div>
                            <div class="form-group my-2">
                                <label>Role:</label>
                                <select class="form-select" name="role" id="role">
                                    <?php

                                        if($row['role'] == 1){
                                            echo "<option selected value='1'>Admin</option>";
                                            echo "<option value='0'> Normal User </option>";
                                        }else{
                                            echo "<option value='1'>Admin</option>";
                                            echo "<option selected value='0'> Normal User </option>";
                                        }
                                        
                                    ?>

                                </select>
                            </div>
                            <div class="form-group my-2">
                                <label for="new-image" class="my-1">User Image</label><br>
                                <input type="file" class="my-2" name="new-image" id="new-image">
                                <input type="hidden" name="old-image" value="<?php echo $row['user_image'] ?>">
                                <img src="upload/<?php echo $row['user_image'] ?>" style="width: 100%; height: 300px;" alt="userImage">
                            </div>
                            <input type="submit" name="submit" class="btn btn-primary" value="Update user" />
                        </form>


                <?php
                    }
                
                ?>
            </div>
        </div>
    </div>



</div>









</div>


<?php
include '_footer.php';

?>