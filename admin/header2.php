<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <script src="https://kit.fontawesome.com/6debaee035.js" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>iDiscuss: Coding Forum</title>
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
    </style>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <!-- HEADER! -->
    <div class="header-admin">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <img src="upload/logo.png" alt="" class="logo">
                </div>

                <div class="offset-md-6 col-md-4">

                    <?php

                    session_start();
                    include '_dbconnect.php';
                    $userid = $_SESSION['userid'];
                
                    $sql1 = "SELECT * FROM adminuser WHERE id = $userid";
                    $result1 = mysqli_query($conn, $sql1);

                    if (mysqli_num_rows($result1)) {
                        $row = mysqli_fetch_assoc($result1);
                    ?>
                        <img src="upload/<?php echo $row['user_image'] ?>" style="height: 50px; width: 60px; border-radius: 50%;" alt="">

                        <div class="dropdown" style="display: inline-block;">
                            <button style="margin-left: 10px; background: none; outline: none; border: none; font-size: 20px; font-weight: bold;" class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                Your Information
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                                <li><a class="dropdown-item" href="partials/_logout.php" id="admin-logout"> <?php echo $row['username'] ?> LOGOUT </a></li>
                                <li><a class="dropdown-item"> Welcome <?php echo $row['username'] ?> </a></li>
                                <li><a class="dropdown-item" href="/forum/accountInfo.php?loggedin=true"> Your account info </a></li>
                            </ul>
                        </div>

                    <?php
                    }

                    ?>


                </div>
            </div>
        </div>


    </div>

    <div id="admin-menubar">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="admin-menu">
                        <li> <a href="/forum/index.php?loggedin=true">Home</a> </li>
                        <li> <a href="/forum/about.php?loggedin=true">About</a> </li>
                        <li> <a href="/forum/contact.php?loggedin=true">Contact</a> </li>
                        <!-- <?php
                        include 'partials/_loginModal.php';
                        include 'partials/_signupModal.php';

                        ?> -->
                        <?php
                        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == "true") {
                            echo '<li> <a href="/forum/partials/_logout.php">Logout</a> </li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>