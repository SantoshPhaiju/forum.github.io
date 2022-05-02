<?php
  include '_dbconnect.php';
  // $showError = false;
  
  if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST'){

    
    $email =  $_POST['loginEmail'];
    $pass = md5($_POST['loginPass']);

      $sql = "SELECT * FROM `adminuser` WHERE email = '$email' AND password = '$pass'";
      $result = mysqli_query($conn, $sql);
      
    
        $numRows = mysqli_num_rows($result);
        
        if($numRows == 1){
          
          while($row = mysqli_fetch_assoc($result)){
            
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['userid'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['user_image'] = $row['user_image'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['showAlert'] = "<p style='color: green; text-align: center; margin: 10px 0px;'>You are loggedin!</p>";
            header("location: /forum/index.php?loggedin=true");
            
          }
          
        }else{
          
          setcookie("Error", "<p style='color: green; text-align: center; margin: 10px 0px;'>Invalid Credentials!</p>", time() + 5, "/"); 
          header("location: /forum/index.php");
        }

// }else{
//   $showError = "";
// }

}




  ?>
  