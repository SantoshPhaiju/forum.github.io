<?php

include 'partials/_dbconnect.php';

if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST"){

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
        $target = "admin/upload/" . $new_name;

        if (empty($errors) == true) {
            move_uploaded_file($file_tmp, $target);
        } else {
            print_r($errors);
            die;
        }
    }






    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $userid = $_GET['userid'];

    $sql = "UPDATE adminuser SET `name` = '$name', `username` = '$username', `email` = '$email', `user_image` = '$new_name' WHERE id = '$userid'";

    $old_name = $_POST['old-image'];
    if (mysqli_query($conn, $sql)) {
        if (!empty($_FILES['new-image']['name'])) {
            unlink("admin/upload/" . $old_name);
        }
        // echo "Your details are updted.";
        $update = "Your details are updated.";
    } else {
        echo "Query Failed:";
    }

}


?>




    <?php include 'partials/_dbconnect.php'; ?>
    <?php

    if (isset($_GET['loggedin']) && $_GET['loggedin'] == true) {
        include 'partials/_header.php';
    }
    if(isset($update)){
        echo $update;
    }
    ?>

    <style>
        .contheight {
            min-height: 70vh;
            height: auto;
            background-color: aliceblue;
            width: 900px;
            margin: 0 auto;
            padding: 10px;
        }

        body {
            background: #fafafa;
        }

        .user-image {
            height: auto;
        }

        .user-img {
            height: 200px;
            width: 100%;
        }

        .user-details {
            background-color: #fff;
            padding: 10px;
            height: auto;

        }

        .wel-form {
            margin: 0 auto;
        }

        .cover-img {
            width: 100%;
            height: 200px;
        }

        .input-group {
            /* width: 60%; */
            margin: 0 auto;
        }

        /* To remove the border while focus in bootstrap  */
        textarea:hover,
        input:hover,
        textarea:active,
        input:active,
        textarea:focus,
        input:focus,
        button:focus,
        button:active,
        button:hover,
        label:focus,
        .btn:active,
        .btn.active {
            outline: 0px !important;
            -webkit-appearance: none;
            box-shadow: none !important;
        }
    </style>


   

    <?php

    $sql = "SELECT * FROM adminuser WHERE id = '$userid'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

    ?>


        <div class="contheight my-3">

            <div class="row">
                <div class="col-md-3 ">
                    <div class="user-image">
                        <?php
                            if(empty($row['user_image'])){
                                echo '<img class="user-img" src="admin/upload/userdefault.png" alt="">';
                            }else{
                                echo '<img class="user-img" src="admin/upload/'. $row['user_image'] .'" alt="user-img here">';
                            }
                        ?>
                    </div>
                    <h3>Profile Picture</h3>
                    <h4>Your Details: </h4>
                    <p>Name: <?php echo $row['name'] ?></p>
                    <p>Username: <?php echo $row['username'] ?></p>
                    <p>Email: <?php echo $row['email'] ?></p>
                    <a href="changepassword.php?userid=<?php echo $userid ?>&loggedin=true" class="btn btn-primary my-3">Change Password</a>
                </div>
                <div class="col-md-9">
                    <div class="user-details">
                        <img src="admin/upload/cover.jpg" alt="" class="cover-img">
                        <div class="wel-form">
                            <h2 class="text-center">Edit Your details</h2>
                            <form class="my-4" action="accountInfo.php?loggedin=true&userid=<?Php echo $userid ?>" method="POST" enctype="multipart/form-data">
                                <div class="input-group my-2 w-50">
                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control" placeholder="Name" value="<?php echo $row['name'] ?>" name="name">
                                </div>
                                <div class="input-group my-2 w-50">
                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control" placeholder="Username" name="username" value="<?php echo $row['username'] ?>" >
                                </div>
                                <div class="input-group my-2 w-50">
                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control" placeholder="Email" name="email" value="<?php echo $row['email'] ?>">
                                </div>
                                <div class="input-group my-2 w-50">
                                    <p>Change profile pic: </p>
                                    <input type="file" id="user-image" name="new-image">
                                    <input type="hidden" id="user-image" name="old-image" value="<?php echo $row['user_image'] ?>">
                                    <button name="update" style="margin: 0 auto; border-radius: 5px;" class="btn btn-primary my-3 w-75">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    <?php
    }
    ?>




    <?php include 'partials/_footer.php'; ?>


  