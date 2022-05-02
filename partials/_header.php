<?php

ob_start();

include 'partials/_dbconnect.php';

$page = basename($_SERVER['PHP_SELF']);

switch ($page) {
    case "index.php":
        $page_title = "iDiscuss: Coding Forum";
        break;
    case "about.php":
        $page_title = "About Us";
        break;
    case "contact.php":
        $page_title = "Conatact Us";
        break;
    case "threadlist.php":
        if (isset($_GET['catid'])) {
            $sql_title = "SELECT * FROM categories WHERE category_id = {$_GET['catid']}";
            $result_title = mysqli_query($conn, $sql_title);
            $row_title = mysqli_fetch_assoc($result_title);
            $page_title = $row_title['category_name'];
        }
        break;
    case "thread.php":
        if (isset($_GET['threadid'])) {
            $sql_title = "SELECT * FROM threads WHERE thread_id = {$_GET['threadid']}";
            $result_title = mysqli_query($conn, $sql_title);
            $row_title = mysqli_fetch_assoc($result_title);
            $page_title = $row_title['thread_title'];
        }
        break;
    case "search.php":
        if (isset($_GET['search'])) {
            $page_title = $_GET['search'];
        }
        break;
    default:
        $page_title = "iDiscuss: Coding Froums";
}

?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <script src="https://kit.fontawesome.com/6debaee035.js" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title><?php echo $page_title ?></title>
    <style>
        .header-admin {
            width: 100%;
            background: #1e90ff;
            text-align: center;
            padding: 15px;
        }

        .logo {
            display: inline-block;
            width: 60%;
        }

        .logo img {
            width: 100%;
        }

        #admin-logout {
            margin: 10px 0;
            display: inline-block;
            text-transform: uppercase;
            color: #fff;
            font-weight: bold;
            text-decoration: none;
            font-size: 18px;
        }

        #admin-logout:hover {
            text-decoration: underline;
        }

        #admin-menubar {
            width: 100%;
            background: #f9f9f9;
        }

        #admin-menubar .admin-menu {
            margin-bottom: 0px;
        }

        #admin-menubar li {
            display: inline-block;
            margin: 0 5px 0 0;
        }

        #admin-menubar .admin-menu li a {
            color: #1e90ff;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            text-transform: uppercase;
            padding: 7px 15px;
            display: block;
            transition: all 0.3s;
            cursor: pointer;
        }

        #admin-menubar .admin-menu li a:hover {
            color: #fff;
            background-color: #1e90ff;
        }
        
        .buttonCall {
            width: 250px;
            margin: 0px auto;
            padding: 10px 20px;
            background: #2487ce;
            font-size: 20px;
            border-radius: 5px;
            color: #fff;
            display: flex;
            justify-content: center;
        }

        .buttonCall:hover {
            background: #25a1fa;
            color: #fff;
        }
    </style>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <!-- HEADER! -->
    <div class="header-admin">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <img src="/forum/admin/upload/logo.png" alt="" class="logo">
                </div>

                <div class="offset-md-6 col-md-4">

                    <?php

                    session_start();
                    include '_dbconnect.php';
                    $userid = $_SESSION['userid'];
                    $sql1 = "SELECT * FROM adminuser WHERE id = $userid";
                    $result1 = mysqli_query($conn, $sql1);
                    setcookie("name", "true", time() + (86400 * 7), "/forum");


                    if (mysqli_num_rows($result1)) {
                        $row = mysqli_fetch_assoc($result1);
                    ?>
                        <img src="admin/upload/<?php echo $row['user_image'] ?>" style="height: 50px; width: 60px; border-radius: 50%;" alt="">

                        <div class="dropdown" style="display: inline-block;">
                            <button style="margin-left: 10px; background: none; outline: none; border: none; font-size: 20px; font-weight: bold;" class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                Your Information
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                                <li><a class="dropdown-item" href="partials/_logout.php" id="admin-logout"> <?php echo $row['username'] ?> LOGOUT </a></li>
                                <li><a class="dropdown-item"> Welcome <?php echo $row['username'] ?> </a></li>
                                <li><a class="dropdown-item" href="accountInfo.php?loggedin=true&userid=<?php echo $row['id'] ?>"> Your account info </a></li>
                            </ul>
                        </div>

                    <?php
                    }

                    ?>


                </div>
            </div>
        </div>


    </div>

    <div id="admin-menubar" style="padding: 5px; height: 49px;">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <ul class="admin-menu">
                        <li> <a href="index.php?loggedin=true">Home</a> </li>
                        <li> <a href="about.php?loggedin=true">About</a> </li>
                        <li> <a href="contact.php?loggedin=true">Contact</a> </li>
                        <?php
                        include 'partials/_loginModal.php';
                        include 'partials/_signupModal.php';

                        ?>
                        <?php
                        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == "true") {
                            echo '<li> <a href="partials/_logout.php">Logout</a> </li>';
                        }
                        ?>
                        <li>
                            <div class="dropdown">
                                <a class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    Top Categories
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <?php 
                                        $sql = "SELECT * FROM categories LIMIT 5";
                                        $result = mysqli_query($conn, $sql);
                                        if($result){
                                            while($row = mysqli_fetch_assoc($result)){
                                                echo '<li style="width: 100%;"><a href="threadlist.php?catid='. $row['category_id'] .'">'. $row['category_name'] .'</a></li>';
                                            }
                                        }
                                    ?>
                                    
                                </ul>
                            </div>
                        </li>
                    </ul>
                        
                </div>
                <div class="col-md-4">
                <div class="input-group ps-5">
                    <?php
                   echo  '<form  method="GET" action="search.php" style="display: inherit;">
                            <div id="navbar-search" style="height: auto; display: inherit;" class="form-outline">
                                <input name="search" type="search" id="form1" placeholder="Search" class="form-control" />
                            </div>
                            <button type="submit" style="height: 37px;" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>';
                    ?>
                </div>

            </div>
        </div>
    </div>
    