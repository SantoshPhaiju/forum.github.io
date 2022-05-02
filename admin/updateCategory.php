<?php



$id = $_GET['id'];


include '_dbconnect.php';


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

                $sql = "SELECT * FROM `categories` WHERE category_id = $id";
                $result = mysqli_query($conn, $sql);

                if($result){
                    $row = mysqli_fetch_assoc($result);
                }



            ?>
            <div class="col-md-offset-4 col-md-4">

                <h1 class="heading">Update category:</h1>
                <form class="my-3" action="save-update-category.php?id=<?php echo $id ?>" method="POST" enctype="multipart/form-data">
                    <div class="form-group my-2">
                        <label>Category Name:</label>
                        <input type="text" name="catName" value="<?php echo $row['category_name'] ?>" class="form-control" placeholder="" required>
                    </div>
                    <div class="form-group my-2">
                        <label>Description:</label>
                        <textarea name="desc" class="form-control" rows="5" required=""><?php echo $row['category_description'] ?></textarea>
                    </div>
                    <div class="form-group my-2">

                        <label for="catImg" class="my-1">Category Image</label><br>
                        <img class="my-2" src="upload/<?php echo $row['category_img'] ?>" style="height: 200px; width: 100%;" alt="image here.">
                        <br>
                        <input type="file" name="new-image" id="catImg">
                        <input type="hidden" name="old-image" value="<?php echo $row['category_img'] ?>">
                    </div>
                    <input type="submit" name="submit" class="btn btn-primary" value="Update category" />
                </form>

            </div>
        </div>
    </div>



</div>









</div>


<?php
include '_footer.php';
?>