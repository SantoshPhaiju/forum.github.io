<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Welcome to iDiscuss - Coding Forums </title>
    <style>
        .contheight{
            min-height: 70vh;
        }
        body{
            background: #fafafa;
        }
        div.user-info{
            border-radius: 10px;
            height: auto;
            width: 600px;
            background: #ffa908;
            /* border: 2px solid blue; */
            box-shadow: 2px 2px 4px 2px #000;
            margin: 60px auto;
        }

        div.head{
            background: #fff;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            /* border: 1px solid black; */
            text-align: center;
            padding: 10px;
        }

        div.bod{
            min-height: 200px;
            background: #352323;
            color: #fff;
            text-align: center;
            color: #dee2e6;
        }

        div.fote{
            padding: 10px;
            background: #fff;
            text-align: center;
            vertical-align: middle;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }
       
     
    </style>
</head>

<body>

    <?php include '_dbconnect.php'; ?>
    <?php 
    
    if(isset($_GET['loggedin']) && $_GET['loggedin'] == true){
        include '_header.php'; 
    }
    ?>
   
    <div class="container contheight my-3">

    <div class="user-info">
        <div class="head">
            <h2>Your Profile</h2>
        </div>
        <div class="bod">
            <?php  

            $userid = $_SESSION['userid'];
            $sql = "SELECT * FROM `adminuser` WHERE id = $userid";
            if($result = mysqli_query($conn, $sql)){
                $row = mysqli_fetch_assoc($result);
                
            
?>
            <h3>Id : <?php echo $row['id'] ?></h3>
            <h3>Name : <?php echo $row['name'] ?></h3>
            <h3>Username : <?php echo $row['username'] ?></h3>
            <h3>Email : <?php echo $row['email'] ?></h3>
            
            <?php
            }
            ?>
        </div>
        <div class="fote" style="font-size: 18px; font-weight: bold;">
            <p style="margin: 0px;">Copyright &copy; iDiscuss 2022</p>
        </div>
    </div>

    </div>



    <?php include '_footer.php'; ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


</body>

</html>