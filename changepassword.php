<?php
include 'partials/_dbconnect.php';

if (!isset($_GET['loggedin']) && $_GET['loggedin'] != true) {
    header("location: index.php");
}

$userid = $_GET['userid'];

session_start();

if($_SESSION['userid'] != $userid){
    header("location: changepassword.php?loggedin=true&userid={$_SESSION['userid']}");
}


if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST"){
    $oldpassword = md5($_POST['oldpassword']);
    $npass = md5($_POST['npass']);
    $cpass = md5($_POST['cpass']);

    $sql = "SELECT * FROM adminuser WHERE id = '$userid'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $hashpass = $row['password'];

if($result){
    if($oldpassword == $row['password']){
        if($npass == $cpass){
            $sql = "UPDATE adminuser SET `password` = '$npass' where id = '$userid'";
            $result = mysqli_query($conn, $sql);
            if($result){
                header("location: accountInfo.php?loggedin=true&userid=$userid");
            }
        }
        else{
            echo "New and confirm password not matched.";
        }
    }else{
        echo "Old password not matched.";
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
    <title>Change password</title>
    <style>
        .container{
            width: 500px;
            margin-top: 100px;
            text-align: center;
        }
        .input-group{
            margin: 0 auto;
        }
        h1{
            color: darkorchid;
            font-family: fira code;
        }
        p{
            font-family: monospace;
        }
        #bottom{
            font-family: cascadia code;
            color: cornflowerblue;
        }
        .btn{
            font-size: large;
            font-family: fira code;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Change Password</h1>
        <p>Fill all the details correctly</p>
        <form action="changepassword.php?loggedin=true&userid=<?php echo $userid ?>" method="POST">
            <div class="input-group my-3 w-75">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                <input type="password" class="form-control" placeholder="Old Password" name="oldpassword" required>
            </div>
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
    </body>

</html>