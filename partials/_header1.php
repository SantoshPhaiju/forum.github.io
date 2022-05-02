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
            margin: 0 0px 0 0;
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

            </div>
        </div>


    </div>

    <div id="admin-menubar" style="padding: 5px; height: 49px;">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <ul class="admin-menu">
                        <?php
                        include 'partials/_loginModal.php';
                        include 'partials/_signupModal.php';
                        ?>
                        <li> <a href="index.php">Home</a> </li>
                        <li> <a href="about.php">About</a> </li>
                        <li> <a href="contact.php">Contact</a> </li>
                        <li> <a data-bs-toggle="modal" data-bs-target="#loginModal">login</a></li>
                        <li><a data-bs-toggle="modal" data-bs-target="#signupModal">signup</a></li>
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

                </div>
                <div class="col-md-4">
                    <div class="input-group ps-5">
                        <?php


                        echo '<form action="search.php" method="GET" style="display: inherit;">';

                        echo '<div id="navbar-search" style="height: auto; display: inherit;" class="form-outline">
                                <input name="search" type="search" id="form1" placeholder="Search" class="form-control" />
                            </div>
                            <button type="submit" style="height: 37px;" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>';
                        ?>
                    </div>
                    </ul>
                </div>
            </div>
        </div>
    </div>