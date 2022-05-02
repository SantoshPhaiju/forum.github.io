
<?php

include '_header.php';
if(!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] != true){
    header("location: index.php");
}
?>

<div id="admin-content">

    <div class="container my-5">
        <div class="row">
            <div class="col-md-offset-4 col-md-4">
                <h1 class="heading">Add new category:</h1>
                <form class="my-3" action="save-category.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group my-2">
                        <label>Category Name:</label>
                        <input type="text" name="catName" class="form-control" placeholder="" required>
                    </div>
                    <div class="form-group my-2">
                        <label>Description:</label>
                        <textarea name="desc" class="form-control" rows="5" required=""></textarea>
                    </div>
                    <div class="form-group my-2">

                        <label for="catImg" class="my-1">Category Image</label><br>

                        <input type="file" name="catImg" id="catImg">
                    </div>
                    <input type="submit" name="submit" class="btn btn-primary" value="Add category" />
                </form>

            </div>
        </div>
    </div>



</div>









</div>


<?php
include '_footer.php';
?>