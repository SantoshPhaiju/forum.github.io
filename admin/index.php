<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">


  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <style>
    body {
      background: #f1f1f1;
      font-family: sans-serif, arial, Helvetica;
    }

    /* .container {
      margin-top: 100px;
    } */

    img.logo {
      width: 100%;
      height: auto;
      display: block;

    }

    form {
      background: #fff;
      padding: 25px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.13);
    }
    .col-md-offset-4{
      margin-left: 33.3333%;
    }
  </style>

  <title>iDiscuss: Coding Forums</title>
</head>

<body>
  <?php
  include '_dbconnect.php';
  
  $showError = false;
  
  if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST'){

    
    $email =  $_POST['loginEmail'];
    $pass = md5($_POST['loginPass']);
    
    if(!empty($email) && !empty($pass)){

    
      $sql = "SELECT * FROM `adminuser` WHERE email = '$email' AND password = '$pass'";
      $result = mysqli_query($conn, $sql);
      
      $numRows = mysqli_num_rows($result);
  
    if($numRows == 1){
      
      while($row = mysqli_fetch_assoc($result)){
        
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['log'] = "<p style='color: green; text-align: center; margin: 10px 0px;'>You are loggedin!</p>";
        $_SESSION['userid'] = $row['id'];
        $_SESSION['username'] = $row['username'];
      $_SESSION['user_image'] = $row['user_image'];
      $_SESSION['role'] = $row['role'];
      setcookie("role", $_SESSION["role"], time() + 86400, "/");
      setcookie('name', 'true', time() + 86400, "/forum");
      
      header("location: showCategory.php");
     
    }
    
  }else{
    $showError = "<p style='color: red; text-align: center; margin: 10px 0px;'>Invalid Credentials</p>";
  }
}

}




  ?>
  

  <div class="container my-5">
    <div class="row">
      <div class="col-md-offset-4 col-md-4">
        <img class="logo" src="/forum/admin/upload/logo.png" alt="">
        <?php echo $showError; ?>
        <h3 class="heading">Admin</h3>
        <form class="my-3" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
          <div class="form-group my-2">
            <label>Username</label>
            <input type="text" name="loginEmail" class="form-control" placeholder="" required>
          </div>
          <div class="form-group my-2">
            <label>Password</label>
            <input type="password" name="loginPass" class="form-control" placeholder="" required>
          </div>
          <input type="submit" name="login" class="btn btn-primary" value="login" />
        </form>

      </div>
    </div>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>