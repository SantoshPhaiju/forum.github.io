



 <?php

include 'partials/_dbconnect.php';


if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];



    $sql = "SELECT * FROM adminuser WHERE `email` = '$email'";
    $result = mysqli_query($conn, $sql);

    $numRows = mysqli_num_rows($result);

    if ($numRows > 0) {
        $row = mysqli_fetch_assoc($result);
        $token = $row['token'];
        $username = $row['username'];


        $to_email = $email;
        $subject = "Recover your account.";
        $body = "Hi $username, Please click the link below to recover your password
        http://localhost/forum/recoverpassword.php?token=$token";
        $headers = "From: santoshphaiju@gmail.com";

        if (mail($to_email, $subject, $body, $headers)) {
            $alert = "<p class='text-white bg-success p-1'>Please check your email at $email to recover your account.</p>";
        } else {
            echo "Mail sending failed.";
        }
    } else {
        echo "Email not found.";
    }
}

?>












<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recover Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/6debaee035.js" crossorigin="anonymous"></script>
    <style>
        body {
            background-color: #f0f2f5;
        }

        .container {
            min-height: 96vh;
        }

        .data {
            text-align: center;
            margin: 100px auto;
            width: 600px;
            /* border: 2px solid blue; */
            background-color: aliceblue;
            padding: 10px;
            height: 380px;
            /* justify-content: center; */
            /* margin-top: 50px; */
            padding-top: 50px;
            box-shadow: 2px 2px 8px 2px #5099f9;

        }

        h1 {
            /* font-weight: bold; */
            /* font-style: italic; */
            color: cornflowerblue;
            font-family: fira code;
        }

        p {
            color: crimson;
            font-family: cascadia code;
        }

        .input-group {
            margin: 0 auto;

        }

        .btn {
            /* font-weight: bold; */
            font-size: 18px;
            font-family: fira code;
        }
    </style>
</head>

<body>

   





    <div class="container">
        <div class="row">
            <div class="data">
                <h1>Recover Account</h1>
                <p>Fill the data correctly</p>
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                    <div class="input-group my-2 w-50">
                        <?php 
                            if(isset($alert)){
                                echo $alert;
                            }
                        ?>
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-envelope"></i></span>
                        <input type="email" class="form-control" placeholder="Email ID" name="email">

                    </div>
                    <button class="btn btn-primary my-3">Recover Account</button>
                </form>
            </div>
        </div>
    </div>


    <?php include 'partials/_footer.php'; ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>