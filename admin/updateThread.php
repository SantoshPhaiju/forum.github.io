<?php
include '_dbconnect.php';
$id = $_GET['id'];


if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST"){
    $thread_title = mysqli_real_escape_string($conn, $_POST['thread_title']);
    $thread_desc = mysqli_real_escape_string($conn, $_POST['thread_desc']);

    $sql = "UPDATE threads SET `thread_title` = '$thread_title', `thread_desc` = '$thread_desc' WHERE thread_id = $id";
    $result = mysqli_query($conn, $sql);
    if($result){
        header("location: showThreads.php");
    }else{
        echo "Query Failed";
    }
}
?>


<?php

include '_header.php';
if(!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] != true){
    header("location: index.php");
}
?>

<div id="admin-content">

    <div class="container my-5">
        <div class="row">
            <?php 

                $sql = "SELECT * FROM `threads` WHERE thread_id = $id";
                $result = mysqli_query($conn, $sql);

                if($result){
                    $row = mysqli_fetch_assoc($result);
                }

            ?>
            <div class="col-md-offset-4 col-md-4">
                <h1 class="heading">Edit your thread:</h1>

                <form class="my-3" action="<?php $_SERVER['PHP_SELF'] ?>?id=<?php echo $id ?>" method="POST" enctype="multipart/form-data">
                    <div class="form-group my-2">
                        <label>Thread title:</label>
                        <input type="text" name="thread_title" value="<?php echo $row['thread_title'] ?>" class="form-control" placeholder="" required>
                    </div>
                    <div class="form-group my-2">
                        <label>Description:</label>
                        <textarea name="thread_desc" class="form-control" rows="5" required=""><?php echo $row['thread_desc'] ?></textarea>
                    </div>
                   
                    <input type="submit" name="submit" class="btn btn-primary" value="Update thread" />
                </form>

            </div>
        </div>
    </div>



</div>









</div>


<?php
include '_footer.php';
?>