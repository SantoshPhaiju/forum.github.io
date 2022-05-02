<?php
include 'partials/_dbconnect.php';

$token = $_GET['token'];


if(!isset($token)){
    header("location: index.php");
}


if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST"){
    $npass = md5($_POST['npass']);
    $cpass = md5($_POST['cpass']);

    $sql = "SELECT * FROM adminuser WHERE token = '$token'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

if($result){
        if($npass == $cpass){
            $sql = "UPDATE adminuser SET `password` = '$npass' where token = '$token'";
            $result = mysqli_query($conn, $sql);
            if($result){
                $change = "Your password has been changed.";
                setcookie('change', $change, time() + 3, '/forum');
                header("location: index.php");
            }
        }
        else{
            echo "New and confirm password not matched.";
        }
   
}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/6debaee035.js" crossorigin="anonymous"></script>
    <title>Recover password</title>
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
        <div class="data">

            <h1>Change Password</h1>
            <p>Fill all the details correctly</p>
            <form action="recoverpassword.php?token=<?php echo $_GET['token'] ?>" method="POST">
            <div class="input-group my-3 w-75">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                <input type="password" class="form-control" placeholder="New Password" name="npass" required>
            </div>
            <div class="input-group my-3 w-75">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                <input type="password" class="form-control" placeholder="Confirm Password" name="cpass" required>
            </div>
            <p id="bottom">New and Confirm password must be same.</p>
            <button class="btn btn-primary">Change Password</button>
        </form>
    </div>
    </div>
    </body>

</html>